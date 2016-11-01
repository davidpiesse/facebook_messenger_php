<?php

namespace mapdev\FacebookMessenger\Exceptions;

class CouldNotReadWebhook extends \Exception
{
    public static function noData()
    {
        return new static('No data was found in the HTTP body');
    }

    public static function invalidData()
    {
        return new static('Invalid data structure');
    }

    public static function other($message)
    {
        return new static($message);
    }
}