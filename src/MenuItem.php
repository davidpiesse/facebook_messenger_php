<?php
namespace mapdev\FacebookMessenger;

class MenuItem
{
    protected $type;
    protected $title;
    protected $url;
    protected $postback;

    /**
     * MenuItem constructor.
     * @param $type
     * @param $title
     * @param $url
     * @param $payload
     */
    public function __construct($type, $title, $url = null, $postback = null)
    {
        $this->type = ButtonType::check($type);
        $this->title = MessengerUtils::checkStringLength($title,30);
        $this->url = $url;
        $this->postback = MessengerUtils::checkStringLength($postback,1000);
    }

    public function toData(){
        $data = [
            'type' => $this->type,
            'title' => $this->title,
        ];
        if($this->type == ButtonType::Web)
            $data['url'] =$this->url;
        if($this->type == ButtonType::Postback)
            $data['payload'] =$this->postback;
        return $data;
    }

}