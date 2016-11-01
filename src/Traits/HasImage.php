<?php

namespace mapdev\FacebookMessenger\Traits;


trait HasImage
{
    public $image;

    public function image($image)
    {
        $this->image = $image;
        return $this;
    }
}