<?php

namespace mapdev\FacebookMessenger;

use Carbon\Carbon;

class Delivered
{
    public $mids = [];
    public $watermark;
    public $datetime;
    public $seq;

    /**
     * Delivered constructor.
     * @param $delivery
     */
    public function __construct($delivery, $useCarbonDate = false)
    {
        $this->mids = Helper::array_find($delivery, 'mids');
        $this->watermark = Helper::array_find($delivery, 'watermark');
        if ($useCarbonDate)
            $this->datetime = Carbon::createFromTimestamp($this->watermark / 1000); //if  needed
        $this->seq = Helper::array_find($delivery, 'seq');
    }
}