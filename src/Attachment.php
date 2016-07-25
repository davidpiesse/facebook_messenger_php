<?php

namespace mapdev\FacebookMessenger;


class Attachment
{

    public $type;
    public $isImage = false;
    public $isVideo = false;
    public $isAudio = false;
    public $isFile = false;
    public $isLocation = false;
    public $isTemplate = false;
    public $isFallback = false;

    public $title;
    public $url;
    public $location;
    public $template;
    public $payload;

    /**
     * Attachment constructor.
     * @param $attachemnt
     */
    public function __construct($attachment)
    {
        $this->type = Helper::array_find($attachment, 'type');
        $this->isImage = ($this->type == 'image');
        $this->isAudio = ($this->type == 'audio');
        $this->isVideo = ($this->type == 'video');
        $this->isFile = ($this->type == 'file');
        $this->isLocation = ($this->type == 'location');
        $this->isTemplate = ($this->type == 'template');
        $this->isFallback = ($this->type == 'fallback');

        if ($this->isImage || $this->isAudio || $this->isVideo || $this->isFile)
            $this->url = Helper::array_find($attachment, 'payload.url');

        if ($this->isLocation) {
            $this->location = Helper::array_find($attachment, 'payload.coordinates');
            $this->title = Helper::array_find($attachment, 'title');
            $this->url = Helper::array_find($attachment, 'url');
        }

        if ($this->isTemplate) {
            $this->template_type = Helper::array_find($attachment, 'payload.template_type');
//TODO
//need to access SendAPI object to get options
        }

        if ($this->isFallback) {
            $this->title = Helper::array_find($attachment, 'title');
            $this->url = Helper::array_find($attachment, 'url');
            $this->payload = Helper::array_find($attachment, 'payload'); //not sure what the output is here?
        }
    }
}