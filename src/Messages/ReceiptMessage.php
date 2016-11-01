<?php
namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Components\ReceiptAddress;
use mapdev\FacebookMessenger\Components\ReceiptSummary;
use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\Traits\MessageTrait;
use JsonSerializable;

class ReceiptMessage implements MessageInterface, JsonSerializable
{
    use MessageTrait;

    public $recipient_name;

    public function recipient_name($name)
    {
        $this->recipient_name = $name;
        return $this;
    }

    public $order_number;

    public function order_number($order_number)
    {
        $this->order_number = $order_number;
        return $this;
    }

    public $currency;

    public function currency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public $payment_method;

    public function payment_method($payment_method)
    {
        $this->payment_method = $payment_method;
        return $this;
    }

    public $timestamp = null;

    public function timestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public $order_url = null;

    public function order_url($order_url)
    {
        $this->order_url = $order_url;
        return $this;
    }

    public $address = null;

    public function address(ReceiptAddress $address)
    {
        $this->address = $address;
        return $this;
    }

    public $summary = null;

    public function summary(ReceiptSummary $summary)
    {
        $this->summary = $summary;
        return $this;
    }

    public $adjustments = [];

    public function adjustments(array $adjustments)
    {
        $this->adjustments = $adjustments;
        return $this;
    }

    public $elements = [];

    public function elements(array $elements)
    {
        $this->elements = $elements;
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

        $payload = [
            'template_type' => 'receipt',
            'recipient_name' => $this->recipient_name,
            'order_number' => $this->order_number,
            'currency' => $this->currency,
            'payment_method' => $this->payment_method,
            'summary' => $this->summary,
            'elements' => $this->elements
        ];

        if (!is_null($this->timestamp)) {
            $payload['timestamp'] = $this->timestamp;
        }
        if (!is_null($this->order_url)) {
            $payload['order_url'] = $this->order_url;
        }
        if (!is_null($this->address)) {
            $payload['address'] = $this->address;
        }
        if (!is_null($this->adjustments)) {
            $payload['adjustments'] = $this->adjustments;
        }

        return [
            'recipient' => [
                'id' => $this->recipient_id
            ],
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => $payload
                ]
            ]
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}