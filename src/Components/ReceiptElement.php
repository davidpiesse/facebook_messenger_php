<?php

namespace mapdev\FacebookMessenger\Components;

class ReceiptElement implements \JsonSerializable
{
    public $title;

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public $subtitle = null;

    public function subtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public $quantity;

    public function quantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    public $price = 0;

    public function price($price)
    {
        $this->price = $price;
        return $this;
    }

    public $currency;

    public function currency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public $image_url;

    public function image_url($image_url)
    {
        $this->image_url = $image_url;
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
        $result = [
            'title' => $this->title,
            'price' => $this->price,
        ];
        if (!is_null($this->subtitle)) {
            $result['subtitle'] = $this->subtitle;
        }
        if (!is_null($this->quantity)) {
            $result['quantity'] = $this->quantity;
        }
        if (!is_null($this->currency)) {
            $result['currency'] = $this->currency;
        }
        if (!is_null($this->image_url)) {
            $result['image_url'] = $this->image_url;
        }
        return $result;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}