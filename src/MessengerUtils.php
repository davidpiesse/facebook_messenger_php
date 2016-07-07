<?php
namespace mapdev\FacebookMessenger;

class MessengerUtils
{
    public static function checkStringLength($string,$max_len){
        if(strlen($string) > $max_len)
            throw new \Exception('String Parameter exceeds length of '.$max_len);
        return $string;
    }

    public static function checkArraySize($array,$max_size){
        if(count($array) > $max_size)
            throw new \Exception('Array Parameter exceeds size of '.$max_size);
        return $array;
    }

    public static function checkStringEncoding($string,$encoding){
        if(!mb_detect_encoding($string, $encoding, true))
            throw new \Exception('String is not encoded as '.$encoding);
        return $string;
    }

    public static function checkPhoneNumber($string){
        if(!starts_with($string,'+'))
            throw new \Exception('String is not a valid phone number');
        return $string;
    }
}