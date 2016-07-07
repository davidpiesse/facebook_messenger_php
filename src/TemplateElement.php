<?php
namespace mapdev\FacebookMessenger;

class TemplateElement implements TemplateInterface
{
    public $title; //80 char
    public $item_url;
    public $image_url;
    public $subtitle; //80char
    public $buttons = []; //max 3

    public function __construct($title, $item_url = null, $image_url = null, $subtitle = null, $buttons = [])
    {
        $this->title = MessengerUtils::checkStringLength($title, 80);
        $this->item_url = $item_url;
        $this->image_url = $image_url;
        $this->subtitle = MessengerUtils::checkStringLength($subtitle, 80);
        $this->buttons = MessengerUtils::checkArraySize($buttons, 3);
    }

    public function toData()
    {
        $result = [
            'title' => $this->title
        ];

        if(!is_null($this->item_url))
            $result['item_url'] = $this->item_url;

        if(!is_null($this->image_url))
            $result['image_url'] = $this->image_url;

        if(!is_null($this->subtitle))
            $result['subtitle'] = $this->subtitle;

        if(count($this->buttons) > 0)
            $result['buttons'] = collect($this->buttons)->map(function($item){
                return $item->toData();
            });
        return $result;
    }
}