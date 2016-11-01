<?php

namespace mapdev\FacebookMessenger\Components;

class ReceiptAddress implements \JsonSerializable
{
    public $street_1;

    public function street_1($street)
    {
        $this->street_1 = $street;
        return $this;
    }

    public $street_2 = '';

    public function street_2($street)
    {
        $this->street_2 = $street;
        return $this;
    }

    public $city;

    public function city($city)
    {
        $this->city = $city;
        return $this;
    }

    public $postal_code;

    public function postal_code($postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    public $state;

    public function state($state)
    {
        $this->state = $state;
        return $this;
    }

    public $country;

    public function country($country)
    {
        $this->country = $country;
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
            'street_1' => $this->street_1,
            'street_2' => $this->street_2,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}