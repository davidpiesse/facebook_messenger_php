<?php

namespace mapdev\FacebookMessenger\Components;

use mapdev\FacebookMessenger\MessengerUtils;

class ReceiptSummary implements \JsonSerializable
{
    public $total_cost;

    public function total_cost($total_cost)
    {
        $this->total_cost = $total_cost;
        return $this;
    }

    public $subtotal = null;

    public function subtotal($subtotal)
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    public $shipping_cost;

    public function shipping_cost($shipping_cost)
    {
        $this->shipping_cost = $shipping_cost;
        return $this;
    }

    public $total_tax;

    public function total_tax($total_tax)
    {
        $this->total_tax = $total_tax;
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
            'total_cost' => $this->total_cost,
        ];
        if (!is_null($this->subtotal)) {
            $result['subtotal'] = $this->subtotal;
        }
        if (!is_null($this->shipping_cost)) {
            $result['shipping_cost'] = $this->shipping_cost;
        }
        if (!is_null($this->total_tax)) {
            $result['total_tax'] = $this->total_tax;
        }
        return $result;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}