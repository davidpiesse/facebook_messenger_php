<?php
namespace mapdev\FacebookMessenger;

class AttachmentMessage implements MessageInterface
{
    protected $attachment;

    public function __construct($attachment)
    {
        $this->attachment = $attachment;
    }

    public function toData()
    {
        return [
            'message' => [
                'attachment' => $this->attachment->toData()
            ]
        ];
    }
}