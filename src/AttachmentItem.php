<?php
/**
 * Created by PhpStorm.
 * User: davidpiesse
 * Date: 25/07/2016
 * Time: 22:15
 */

namespace mapdev\FacebookMessenger;

class AttachmentItem implements MessageInterface
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