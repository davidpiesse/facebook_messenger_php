<?php
namespace mapdev\FacebookMessenger;

use mapdev\FacebookMessenger\Exceptions\CouldNotCreateMessage;

class MessengerUtils
{
    public static function checkStringLength($string, $max_len)
    {
        if (strlen($string) > $max_len) {
            throw CouldNotCreateMessage::textExceedsMaximumLength($max_len);
        }
        return $string;
    }

    public static function checkArraySize($array, $max_size)
    {
        if (count($array) > $max_size) {
            throw CouldNotCreateMessage::arrayExceedsMaximumSize($max_size);
        }
        return $array;
    }

    public static function checkStringEncoding($string, $encoding)
    {
        if (!mb_detect_encoding($string, $encoding, true)) {
            throw CouldNotCreateMessage::incorrectEncoding($encoding);
        }
        return $string;
    }

    public static function checkPhoneNumber($string)
    {
        if (!starts_with($string, '+')) {
            throw CouldNotCreateMessage::invalidPhoneNumber();
        }
        return $string;
    }

    public static function checkStringLengthAndEncoding($string, $max_len, $encoding)
    {
        return self::checkStringEncoding(self::checkStringLength($string, $max_len), $encoding);
    }
}