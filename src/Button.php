<?php
namespace mapdev\FacebookMessenger;

class Button implements TemplateInterface
{
    public $type;
    public $title;
    public $url;
    public $payload;
    public $phone_number;

    /**
     * Button constructor.
     * @param $type
     * @param $title
     * @param null $url
     * @param null $payload
     * @param null $phone_number
     */
    public function __construct($type, $title, $url = null, $payload = null, $phone_number = null)
    {
        $this->type = $type;
        $this->title = MessengerUtils::checkStringLength($title, 20);
        $this->url = $url;
        $this->payload = MessengerUtils::checkStringLength($payload, 1000);
        if(!is_null($phone_number))
            $this->phone_number = MessengerUtils::checkPhoneNumber($phone_number);
    }

    public function toData()
    {
        $result = [
            'type' => $this->type,
            'title' => $this->title
        ];

        switch ($this->type) {
            case 'web_url':
                $result['url'] = $this->url;
                break;
            case 'postback':
                $result['payload'] = $this->payload;
                break;
            case 'phone_number':
                $result['payload'] = $this->phone_number;
                break;
        }

        return $result;
    }
}