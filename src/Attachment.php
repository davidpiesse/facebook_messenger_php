<?php

namespace mapdev\FacebookMessenger;

//needed???
class Attachment implements MessageInterface
{
    protected $type;

    protected $payload;
    protected $url;

    public function __construct($type , $url)
    {
        $this->type = $type;
        $this->url = $url;
    }

    public function toData()
    {
        return [
            'type' => $this->type,
            'payload' => [
                'url' => $this->url
            ]
        ];
        
    }
}