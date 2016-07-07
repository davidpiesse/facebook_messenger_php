<?php
namespace mapdev\FacebookMessenger;

class PostbackReceived extends CallbackMessage
{
    public $timestamp;
    public $payload;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->timestamp = $message['timestamp'];
        $this->payload = $message['postback']['payload'];
    }

}