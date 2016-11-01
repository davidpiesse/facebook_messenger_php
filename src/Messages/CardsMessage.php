<?php

namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\MessageTrait;
use JsonSerializable;

class CardsMessage implements MessageInterface, JsonSerializable
{
    use MessageTrait;

    public $cards;

    public function cards($cards)
    {
        $this->cards = $cards;
        return $this;
    }

    public function __construct()
    {
    }

    public static function create()
    {
        return new static();
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
                        'template_type' => 'generic',
                        'elements' => MessengerUtils::checkArraySize($this->cards, 10)
                    ]
                ]
            ]
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}