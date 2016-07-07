<?php

namespace mapdev\FacebookMessenger;

class TextMessage implements MessageInterface
{
    protected $text; //320 char

    public function __construct($text)
    {
        $this->text = MessengerUtils::checkStringEncoding(MessengerUtils::checkStringLength($text,320),'UTF-8');
    }

    public function toData()
    {
        return [
            'message' => [
                'text' => $this->text
            ]
        ];
    }
}