<?php

namespace mapdev\FacebookMessenger\Callback;

use mapdev\FacebookMessenger\Helper;

class Authentication
{
    public $ref;

    /**
     * Delivered constructor.
     * @param $authentication
     */
    public function __construct($authentication)
    {
        $this->ref = Helper::array_find($authentication, 'ref');
    }
}