<?php
namespace mapdev\FacebookMessenger;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use mapdev\FacebookMessenger\Enums\FileType;
use mapdev\FacebookMessenger\Enums\ThreadSettingState;
use mapdev\FacebookMessenger\Enums\ThreadSettingType;

/**
 * Class Messenger
 * @package mapdev\FacebookMessenger
 */
class Messenger
{
    protected $api;

    protected $notification_type = null;

    public static function create($token)
    {
        return new static($token);
    }

    public function __construct($token)
    {
        $this->api = new MessengerApi($token);
    }

    public function hubReply(Request $request, $verify_token)
    {
        if ($request->has('hub_mode') &&
            $request->hub_mode == 'subscribe' &&
            $request->hub_verify_token == $verify_token
        ) {
            return Response::make($request->hub_challenge, 200);
        }
        return Response::make('No Valid Challenge', 400);
    }

    //all message objects have toArray on them...
    public function send($message, $path = 'me/messages')
    {
        return $this->api->callApi($path, $message->toArray());
    }

    public function receive($data)
    {
        //parse incoming data and return a callback object
        return Callback::create($data);
    }

    public function user($user_id)
    {
        return UserProfile::create($this->api->callApi($user_id, null, MessengerApi::GET));
    }

    //Todo Fix Auth
//    public function linkAccount($account_linking_token)
//    {
//        //return PAGE_ID & PSID
//        return $this->api->callApi(
//            'me?fields=recipient&account_linking_token=' . $account_linking_token,
//            [],
//            MessengerApi::GET);
//    }
//
//    public function getLinkAccountPSID($account_linking_token)
//    {
//        //return PAGE_ID & PSID
//        return $this->api->callApi(
//            'me?fields=recipient&account_linking_token=' . $account_linking_token,
//            [],
//            MessengerApi::GET);
//    }
//
//    public function unlinkAccount($psid)
//    {
//        return $this->api->callApi('me/unlink_accounts', [
//            'psid' => $psid,
//        ]);
//    }

//TODO Fix api call - Tried accessing nonexisting field
//    public function validateWebhook($app_id, $page_id)
//    {
//        Log::debug(
//            $this->api->callApi($app_id . '/subscriptions_sample?object_id=' . $page_id . '&object=page&custom_fields={"page_id":' . $page_id.'}',
//                [], MessengerApi::GET)
//        );
//    }

    public function setGreetingText($text)
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'greeting',
            'greeting' => [
                'text' => MessengerUtils::checkStringEncoding(MessengerUtils::checkStringLength($text,
                    160), 'UTF-8')
            ]
        ]);
    }

    public function deleteGreetingText()
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'greeting',
        ], MessengerApi::DELETE);
    }

    public function setGetStartedButton($payload)
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'call_to_actions',
            'thread_state' => ThreadSettingState::NEW_THREAD,
            'call_to_actions' => [
                ['payload' => $payload]
            ]
        ]);
    }

    public function deleteGetStartedButton()
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'call_to_actions',
            'thread_state' => ThreadSettingState::NEW_THREAD,
        ], MessengerApi::DELETE);
    }

    public function setPersistentMenu($menu_items)
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'call_to_actions',
            'thread_state' => ThreadSettingState::EXISTING_THREAD,
            'call_to_actions' => MessengerUtils::checkArraySize(collect($menu_items)->map(function ($item) {
                return $item->toArray();
            })->toArray(), 5)
        ]);
    }

    public function deletePersistentMenu()
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'call_to_actions',
            'thread_state' => ThreadSettingState::EXISTING_THREAD,
        ], MessengerApi::DELETE);
    }

    public function addWhitelistedDomain(array $domains)
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'domain_whitelisting',
            'whitelisted_domains' => MessengerUtils::checkArraySize($domains, 10),
            'domain_action_type' => 'add'
        ]);
    }

    public function removeWhitelistedDomain(array $domains)
    {
        return $this->api->callApi('me/thread_settings', [
            'setting_type' => 'domain_whitelisting',
            'whitelisted_domains' => MessengerUtils::checkArraySize($domains, 10),
            'domain_action_type' => 'remove'
        ]);
    }

    public function sendMessage(\mapdev\FacebookMessenger\MessageInterface $message, $recipient_id)
    {
        return $this->api->callApi('me/messages',
            $this->addRecipient($message->toData(), $recipient_id)
        );
    }

    public function sendAction($action, $recipient_id)
    {
        return $this->api->callApi('me/messages',
            ['sender_action' => $action, 'recipient' => ['id' => $recipient_id]]);
    }

    public function sendFile($file, $recipient_id, $type = FileType::File)
    {
        $data = [
            'message' => ['attachment' => ['type' => $type]],
            'recipient' => ['id' => $recipient_id]
        ];;
        if (is_string($file)) {
            $data['payload'] = ['url' => $file];
        } else {
            $data['filedata'] = $file;
        }
        return $this->api->callApi('me/messages', $data);
    }

    public function sendImage($file, $recipient_id)
    {
        $this->sendFile($file, $recipient_id, FileType::Image);
    }

    public function sendVideo($file, $recipient_id)
    {
        $this->sendFile($file, $recipient_id, FileType::Video);
    }

    public function sendAudio($file, $recipient_id)
    {
        $this->sendFile($file, $recipient_id, FileType::Audio);
    }

    public function sendTemplate(TemplateInterface $template, $recipient_id)
    {
        return $this->api->callApi('me/messages',
            $this->addRecipient($template->toData(), $recipient_id)
        );
    }

    public function quickReply(QuickReply $quick_reply, $recipient_id)
    {
        return $this->api->callApi('me/messages', $quick_reply->toData() + ['recipient' => ['id' => $recipient_id]]);
    }

    protected function addRecipient($data, $recipient_id)
    {
        $data['recipient'] = ['id' => $recipient_id];
        return $data;
    }
}