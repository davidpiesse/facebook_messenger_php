<?php

namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\HasButtons;
use mapdev\FacebookMessenger\Traits\HasText;
use mapdev\FacebookMessenger\Traits\MessageTrait;
use JsonSerializable;

class ButtonMessage implements MessageInterface, JsonSerializable
{
    use MessageTrait, HasText, HasButtons;

    public function __construct($text = null)
    {
        $this->text($text);
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
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'button',
                        'text' => MessengerUtils::checkStringLengthAndEncoding($this->text, 320, 'UTF-8'),
                        'buttons' => MessengerUtils::checkArraySize($this->buttons, 3)
                    ]
                ]
            ]
        ];
    }

    public
    function jsonSerialize()
    {
        return $this->toArray();
    }
}