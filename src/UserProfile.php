<?php

namespace mapdev\FacebookMessenger;


class UserProfile
{
    public $first_name;
    public $last_name;
    public $name;
    public $profile_pic;
    public $locale;
    public $timezone;
    public $gender;

    public static function create($data)
    {
        return new static($data);
    }

    public function __construct($data)
    {
        $this->first_name = $data->first_name;
        $this->last_name = $data->last_name;
        $this->name = $this->first_name.' '.$this->last_name;
        $this->profile_pic = $data->profile_pic;
        $this->locale = $data->locale;
        $this->timezone = $data->timezone;
        $this->gender = $data->gender;
    }
}