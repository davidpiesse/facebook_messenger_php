<?php
namespace mapdev\FacebookMessenger;

use mapdev\FacebookMessenger\Enums\ThreadSettingState;
use GuzzleHttp\Psr7;

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

    public function hubReply(array $data, $verify_token)
    {
        //change to request data array
        if (array_key_exists('hub_mode', $data) &&
            $data['hub_mode'] == 'subscribe' &&
            $data['hub_verify_token'] == $verify_token
        ) {
            return new Psr7\Response(200,null,$data['hub_challenge']);
        }
        return new Psr7\Response(400,null,'No Valid Challenge');
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

    protected function addRecipient($data, $recipient_id)
    {
        $data['recipient'] = ['id' => $recipient_id];
        return $data;
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
}