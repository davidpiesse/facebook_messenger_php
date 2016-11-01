<?php
/**
 * Created by PhpStorm.
 * User: davidpiesse
 * Date: 24/08/2016
 * Time: 09:45
 */

namespace mapdev\FacebookMessenger\Exceptions;


class CouldNotCreateMessage extends \Exception

{
    public static function textExceedsMaximumLength($max_len)
    {
        return new static('String Parameter exceeds length of ' . $max_len);
    }

    public static function arrayExceedsMaximumSize($max_size)
    {
        return new static('Array Parameter exceeds size of ' . $max_size);
    }

    public static function incorrectEncoding($encoding)
    {
        return new static('String is not encoded as ' . $encoding);
    }

    public static function invalidPhoneNumber()
    {
        return new static('String is not a valid phone number');
    }

    public static function invalidParameter($param)
    {
        return new static('You must provide a valid parameter for ' . $param);
    }

    public static function noRecipientDefined()
    {
        return new static('You must define a recipient PSID for the message to be sent to');
    }

    public static function noActionDefined()
    {
        return new static('You must define an Action');
    }

    public static function noStickerDefined()
    {
        return new static('You must define an Sticker');
    }

    public static function noAttachmentType()
    {
        return new static('You must define an attachment Type (File,Image,Audio,Video)');
    }

    public static function noAttachmentUrl()
    {
        return new static('You must define an attachment Url');
    }
}