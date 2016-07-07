<?php
namespace mapdev\FacebookMessenger;

class Reply implements MessageInterface
{

    protected $content_type; //always is 'text'
    protected $title; //20char limit
    protected $payload; //1000 char limit

    public function __construct($content_type, $title, $payload)
    {
        $this->content_type = $content_type;
        $this->title = MessengerUtils::checkStringLength($title,20);
        $this->payload = MessengerUtils::checkStringLength($payload,1000);
    }

    public function toData()
    {
        return [
            'content_type' => $this->content_type,
            'title' => $this->title,
            'payload' => $this->payload,
        ];
    }
}