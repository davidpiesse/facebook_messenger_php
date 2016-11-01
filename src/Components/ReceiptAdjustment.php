<?php

namespace mapdev\FacebookMessenger\Components;

class ReceiptAdjustment implements \JsonSerializable
{
    public $name;

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public $amount;

    public function amount($amount)
    {
        $this->amount = $amount;
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
        return [
            'name' => $this->name,
            'amount' => $this->amount
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}