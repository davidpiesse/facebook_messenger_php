<?php

namespace mapdev\FacebookMessenger\Traits;


trait HasText
{
    public $text;

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }
}