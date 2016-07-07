<?php

namespace mapdev\FacebookMessenger;

class QuickReply implements MessageInterface
{
    protected $text;
    protected $replies;
    protected $attachments;

    public function __construct($text, $replies = [], $attachments = [])
    {
        $this->text = MessengerUtils::checkStringEncoding(MessengerUtils::checkStringLength($text,320),'UTF-8');
        $this->replies = MessengerUtils::checkArraySize($replies,10);
        $this->attachments = $attachments;
    }

    public function toData()
    {
        $quick_replies = collect($this->replies)->map(function ($item, $key) {
            return $item->toData();
        });

        $result = [
            'message' => [
                'text' => $this->text,
                'quick_replies' => $quick_replies
            ]
        ];

        //attachments only image or template...?
        //TODO
        if (count($this->attachments)) {
            $attachments = collect($this->attachments)->map(function ($item, $key) {
                return $item->toData();
            });
            $result['attachments'] = $attachments;
        }
        return $result;
    }
}
