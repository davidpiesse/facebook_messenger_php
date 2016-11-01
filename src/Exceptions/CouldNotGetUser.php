<?php

namespace mapdev\FacebookMessenger\Exceptions;


class CouldNotGetUser extends \Exception
{
    public static function noUserID()
    {
        return new static('No User ID supplied');
    }

    public static function invalidUserID()
    {
        return new static('No user with a PSID provided exists');
    }
}