<?php

namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\HasText;
use mapdev\FacebookMessenger\Traits\MessageTrait;

class QuickReplyMessage implements MessageInterface, \JsonSerializable
{
    use MessageTrait, HasText;

    public $replies;

    public function replies($replies)
    {
        $this->replies = $replies;
        return $this;
    }

    public static function create($text = null)
    {
        return new static($text);
    }

    public function __construct($text = null)
    {
        $this->text($text);
    }

    public function toArray()
    {
        $this->checkRecipient();

        return [
            'recipient' => [
                'id' => $this->recipient_id
            ],
            'message' => [
                'text' => MessengerUtils::checkStringLengthAndEncoding($this->text, 320, 'UTF-8'),
                'quick_replies' => MessengerUtils::checkArraySize($this->replies, 10)
            ]
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}