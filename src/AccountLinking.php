<?php
namespace mapdev\FacebookMessenger;

class AccountLinking extends CallbackMessage
{
    public $timestamp;
    public $status;
    public $authorization_code;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->timestamp = $message['timestamp'];
        $this->status = $message['account_linking']['status'];
        $this->authorization_code = isset($message['account_linking']['authorization_code']) ? $message['account_linking']['authorization_code'] : null;
    }

}