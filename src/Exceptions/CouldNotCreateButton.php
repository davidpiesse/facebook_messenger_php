<?php

namespace mapdev\FacebookMessenger\Exceptions;


class CouldNotCreateButton extends \Exception
{
    public static function noType()
    {
        return new static('No Button type defined');
    }

    public static function noTitle()
    {
        return new static('No title defined');
    }

    public static function noUrl()
    {
        return new static('No url provided for a Web Button');
    }

    public static function noPayload()
    {
        return new static('No payload provided for a Postback Button');
    }

    public static function invalidPhoneNumber()
    {
        return new static('Invalid phone number provided for the Button');
    }

    public static function invalidType()
    {
        return new static('Invalid Type provided for the Button');
    }
}