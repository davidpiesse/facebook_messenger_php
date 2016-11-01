<?php

namespace mapdev\FacebookMessenger\Traits;


trait HasTitle
{
    public $title;

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }
}