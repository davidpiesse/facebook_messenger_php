<?php
namespace mapdev\FacebookMessenger\Enums;

use mapdev\FacebookMessenger\Exceptions\CouldNotCreateButton;

abstract class ButtonType
{
    const Web = 'web_url';
    const Postback = 'postback';
    const PhoneNumber = 'phone_number';
    const Share = 'element_share';
    const AccountLink = 'account_link';
    const AccountUnlink = 'account_unlink';

    public static function check($string)
    {
        if ($string == self::Web || $string == self::Postback ||
            $string == self::PhoneNumber || $string == self::Share ||
            $string == self::AccountLink || $string == self::AccountUnlink
        ) {
            return $string;
        } else {
            throw CouldNotCreateButton::invalidType();
        }
    }
}