<?php
namespace mapdev\FacebookMessenger;

abstract class ButtonType
{
    const Web = 'web_url';
    const Postback = 'postback';
    const PhoneNumber = 'phone_number';

    public static function check($string)
    {
        if ($string == self::Web || $string == self::Postback || $string == self::PhoneNumber)
            return $string;
        else
            throw new \Exception('Invalid Type Defined');
    }
}