<?php
namespace mapdev\FacebookMessenger;

abstract class CallbackMessage
{
    //each messaging object form callback

    public $sender_id;
    public $recipient_id;

    public function __construct($message)
    {
        $this->sender_id = $message['sender']['id'];
        $this->recipient_id = $message['recipient']['id'];
    }
}