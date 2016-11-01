<?php
namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\HasText;
use mapdev\FacebookMessenger\Traits\MessageTrait;

class TextMessage implements MessageInterface, \JsonSerializable
{
    use MessageTrait, HasText;

    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->text($text);
        }
    }

    public static function create($text = null)
    {
        return new static($text);
    }

    public function toArray()
    {
        $this->checkRecipient();

        return [
            'recipient' => [
                'id' => $this->recipient_id
            ],
            'message' => [
                'text' => MessengerUtils::checkStringLengthAndEncoding($this->text,320,'UTF-8')
            ]
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}