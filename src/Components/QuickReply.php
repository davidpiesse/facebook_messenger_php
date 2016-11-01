<?php

namespace mapdev\FacebookMessenger\Components;

use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\HasImage;
use mapdev\FacebookMessenger\Traits\HasTitle;

class QuickReply implements \JsonSerializable
{
    use HasTitle, HasImage;

    public $payload;

    public function payload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    public $location = false;

    public function location()
    {
        $this->location = true;
        return $this;
    }

    public static function create()
    {
        return new static();
    }

    public function __construct()
    {

    }

    public function toArray()
    {
        if ($this->location) {
            return [
                'content_type' => 'location'
            ];
        }

        $result = [
            'content_type' => 'text',
            'title' => MessengerUtils::checkStringLength($this->title, 20),
            'payload' => MessengerUtils::checkStringLength($this->payload, 1000)
        ];

        if (!is_null($this->image)) {
            $result['image_url'] = $this->image;
        }

        return $result;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}