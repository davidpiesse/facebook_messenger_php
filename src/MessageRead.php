<?php
/**
 * Created by PhpStorm.
 * User: davidpiesse
 * Date: 05/07/2016
 * Time: 21:39
 */

namespace mapdev\FacebookMessenger;


class MessageRead extends CallbackMessage
{
    protected $timestamp;
    protected $watermark;
    protected $seq;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->timestamp = $message['timestamp'];
        $this->watermark = $message['read']['watermark'];
        $this->seq = $message['read']['seq'];
    }

}