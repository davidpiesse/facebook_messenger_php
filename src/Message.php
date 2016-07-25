<?php

namespace mapdev\FacebookMessenger;

//TODO make into abstract which other inherit from (text, attachment, postback, read,delivered,auth,linking)
class Message
{

    public $mid;
    public $seq;

    public $isText = false;
    public $isSticker = false;
    public $hasAttachments = false;

    public $text;
    public $quick_reply;
    public $attachments = [];

    /**
     * Message constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->mid = Helper::array_find($message, 'mid');
        $this->seq = Helper::array_find($message, 'seq');

        $this->isText = (!is_null(Helper::array_find($message, 'text')));
        if ($this->isText) {
            $this->text = Helper::array_find($message, 'text');
            $this->quick_reply = Helper::array_find($message, 'quick_reply.payload'); //drill straight to payload
        }

        $this->isSticker = (!is_null(Helper::array_find($message, 'sticker_id')));
        if ($this->isSticker) {
            $this->sticker_id = Helper::array_find($message, 'sticker_id');
        }

        $this->hasAttachments = (!is_null(Helper::array_find($message, 'attachments')));
        if ($this->hasAttachments) {
            $this->attachments = collect(Helper::array_find($message, 'attachments'))->map(function ($attachment) {
                return new Attachment($attachment);
            });
        }
    }
}