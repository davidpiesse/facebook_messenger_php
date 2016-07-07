<?php
namespace mapdev\FacebookMessenger;

class MessageDelivered extends CallbackMessage
{
    protected $mids = [];
    protected $watermark;
    protected $seq;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->mids = $message['delivery']['mids'];
        $this->watermark = $message['delivery']['watermark'];
        $this->seq = $message['delivery']['seq'];
    }

}