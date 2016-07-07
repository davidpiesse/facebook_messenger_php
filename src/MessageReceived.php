<?php
/**
 * Created by PhpStorm.
 * User: davidpiesse
 * Date: 05/07/2016
 * Time: 21:39
 */

namespace mapdev\FacebookMessenger;


class MessageReceived extends CallbackMessage
{
    public $timestamp;
    public $mid;
    public $seq;
    public $text;
    public $attachment;
    public $quick_reply;
    public $is_echo;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->timestamp = $message['timestamp'];
        $this->mid = $message['message']['mid'];
        $this->seq = $message['message']['seq'];
        $this->is_echo = isset($message['message']['is_echo']) ? $message['message']['is_echo'] : null;
        $this->text = isset($message['message']['text']) ? $message['message']['text'] : null;
        $this->attachment = isset($message['message']['attachment']) ? $message['message']['attachment'] : null;
        $this->quick_reply = isset($message['message']['quick_reply']) ? $message['message']['quick_reply'] : null;
    }

}