<?php
namespace mapdev\FacebookMessenger;

class AuthenticationOptin extends CallbackMessage
{
    public $timestamp;
    public $ref;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->timestamp = $message['timestamp'];
        $this->ref = $message['optin']['ref'];
    }

}