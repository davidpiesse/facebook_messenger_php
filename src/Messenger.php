<?php
namespace mapdev\FacebookMessenger;

use Illuminate\Http\Request;

class Messenger
{
    protected $api;

    public function __construct($token)
    {
        $this->api = new MessengerApi($token);
    }

    public function hubReply(Request $request)
    {
        if ($request->has('hub_mode') &&
            $request->hub_mode == 'subscribe' &&
            $request->hub_verify_token == env('VERIFY_TOKEN')
        )
            return response($request->hub_challenge, 200);
        return response('No Valid Challenge', 400);
    }

    public function threadSetting($setting, $greeting_text = null, $payload = null, $menu_items = [])
    {
        $data = ['setting_type' => $setting];
        switch ($setting) {
            case ThreadSettingType::GREETING:
                $data['greeting'] = ['text' => MessengerUtils::checkStringEncoding(MessengerUtils::checkStringLength($greeting_text, 160), 'UTF-8')];
                break;
            case ThreadSettingType::GET_STARTED_BUTTON:
                $data['thread_state'] = ThreadSettingState::NEW_THREAD;
                $data['call_to_actions'] = [MessengerUtils::checkArraySize([
                    'payload' => $payload
                ], 1)];
                break;
            case ThreadSettingType::PERSISTENT_MENU:
                $data['setting_type'] = ThreadSettingType::GET_STARTED_BUTTON;
                $data['thread_state'] = ThreadSettingState::EXISTING_THREAD;
                $data['call_to_actions'] =
                    MessengerUtils::checkArraySize(collect($menu_items)->map(function ($item) {
                        return $item->toData();
                    })->toArray(), 5);
                break;
            case ThreadSettingType::DELETE_GET_STARTED_BUTTON:
                $data['setting_type'] = ThreadSettingType::GET_STARTED_BUTTON;
                $data['thread_state'] = ThreadSettingState::NEW_THREAD;
                return $this->api->callApi('me/thread_settings', $data, MessengerApi::DELETE);
                break;
            case ThreadSettingType::DELETE_PERSISTENT_MENU:
                $data['setting_type'] = ThreadSettingType::GET_STARTED_BUTTON;
                $data['thread_state'] = ThreadSettingState::EXISTING_THREAD;
                return $this->api->callApi('me/thread_settings', $data, MessengerApi::DELETE);
                break;
            default:
                throw new \Exception('Invalid Setting Type defined');
        }
        return $this->api->callApi('me/thread_settings', $data);
    }

    public function sendMessage(MessageInterface $message, $recipient_id)
    {
        return $this->api->callApi('me/messages',
            $this->addRecipient($message->toData(),$recipient_id)
        );
    }

    public function sendAction($action, $recipient_id)
    {
        return $this->api->callApi('me/messages',
            ['sender_action' => $action, 'recipient' => ['id' => $recipient_id]]);
    }

    public function sendFile($file, $recipient_id, $type = FileType::File)
    {
        $data = ['message' => ['attachment' => ['type' => $type]],
            'recipient' => ['id' => $recipient_id]];;
        if(is_string($file))
            $data['payload'] = ['url' => $file];
        else{
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

//    //TODO confirm
//    //https://graph.facebook.com/v2.6/<USER_ID>?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token=PAGE_ACCESS_TOKEN
//    public function userProfile($user_id)
//    {
//        $this->callApi($user_id, [
//            'fields' => 'first_name,last_name,profile_pic,locale,timezone,gender'
//        ], self::GET, false);
//    }
}