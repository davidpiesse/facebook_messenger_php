<?php

namespace mapdev\FacebookMessenger\Callback;

use mapdev\FacebookMessenger\Helper;

class Postback
{
    public $payload;

    /**
     * Delivered constructor.
     * @param $payload
     */
    public function __construct($postback)
    {
        $this->payload = Helper::array_find($postback, 'payload');
    }
}