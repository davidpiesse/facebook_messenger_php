<?php
namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Enums\AttachmentType;
use mapdev\FacebookMessenger\Exceptions\CouldNotCreateMessage;
use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\Traits\MessageTrait;
use JsonSerializable;

class AttachmentMessage implements MessageInterface, JsonSerializable
{
    use MessageTrait;

    public $attachment_type;

    public function type($type)
    {
        $this->attachment_type = $type;
        return $this;
    }

    public $attachment_url;

    public function url($url)
    {
        $this->attachment_url = $url;
        return $this;
    }

    public $is_reuseable = false;

    public function is_reuseable()
    {
        $this->is_reuseable = true;
        return $this;
    }

    public $attachment_id = null;

    public function attachment_id($id)
    {
        $this->attachment_id = $id;
        return $this;
    }

    public function file($url)
    {
        $this->type(AttachmentType::FILE);
        $this->attachment_url = $url;
        return $this;
    }

    public function image($url)
    {
        $this->type(AttachmentType::IMAGE);
        $this->attachment_url = $url;
        return $this;
    }

    public function video($url)
    {
        $this->type(AttachmentType::VIDEO);
        $this->attachment_url = $url;
        return $this;
    }

    public function audio($url)
    {
        $this->type(AttachmentType::AUDIO);
        $this->attachment_url = $url;
        return $this;
    }

    public function __construct($type = AttachmentType::FILE)
    {
        $this->type($type);
    }

    public static function create($type = AttachmentType::FILE)
    {
        return new static($type);
    }

    public function toArray()
    {
        $this->checkRecipient();

        if (is_null($this->attachment_type)) {
            throw CouldNotCreateMessage::noAttachmentType();
        }
        if (is_null($this->attachment_url) && is_null($this->attachment_id)) {
            throw CouldNotCreateMessage::noAttachmentUrl();
        }

        $payload = [
            'url' => $this->attachment_url
        ];

        if ($this->is_reuseable) {
            $payload['is_reuseable'] = true;
        }

        if(!is_null($this->attachment_id)){
            $payload = [
                'attachment_id' => $this->attachment_id
            ];
        }

        return [
            'recipient' => [
                'id' => $this->recipient_id
            ],
            'message' => [
                'attachment' => [
                    'type' => $this->attachment_type,
                    'payload' => $payload
                ]
            ]
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}