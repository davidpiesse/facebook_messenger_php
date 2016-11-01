<?php

namespace mapdev\FacebookMessenger\Callback;

use mapdev\FacebookMessenger\Helper;

class Read
{
    public $watermark;
    public $datetime;
    public $seq;

    /**
     * Read constructor.
     * @param $read
     */
    public function __construct($read, $useCarbonDate = false)
    {
        $this->watermark = Helper::array_find($read, 'watermark');
        if ($useCarbonDate)
            $this->datetime = \Carbon\Carbon::createFromTimestamp($this->watermark / 1000); //if  needed
        $this->seq = Helper::array_find($read, 'seq');
    }
}