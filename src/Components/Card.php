<?php

namespace mapdev\FacebookMessenger\Components;


use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\HasButtons;
use mapdev\FacebookMessenger\Traits\HasTitle;

class Card implements \JsonSerializable
{
    use HasButtons, HasTitle;

    public function __construct()
    {

    }

    public static function create()
    {
        return new static();
    }

    public $item_url;

    public function item_url($item_url)
    {
        $this->item_url = $item_url;
        return $this;
    }

    public $image_url;

    public function image_url($image_url)
    {
        $this->image_url = $image_url;
        return $this;
    }

    public $subtitle;

    public function subtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function toArray()
    {
        //check all buttons for titles!
        return [
            'title' => MessengerUtils::checkStringLength($this->title, 80),
            'item_url' => $this->item_url,
            'image_url' => $this->image_url,
            'subtitle' => MessengerUtils::checkStringLength($this->subtitle, 80),
            'buttons' => MessengerUtils::checkArraySize($this->buttons, 3)
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}