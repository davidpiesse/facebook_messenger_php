<?php

namespace mapdev\FacebookMessenger\Components;

use mapdev\FacebookMessenger\Enums\ButtonType;
use mapdev\FacebookMessenger\Enums\WebviewSize;
use mapdev\FacebookMessenger\MessengerUtils;
use mapdev\FacebookMessenger\Traits\HasTitle;

class Button implements \JsonSerializable
{
    use HasTitle;

    public $type;

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public $payload;

    public function payload($payload)
    {
        $this->type(ButtonType::Postback);
        $this->payload = $payload;
        return $this;
    }

    public function postback($payload)
    {
        return $this->payload($payload);
    }

    public function url($url)
    {
        $this->type(ButtonType::Web);
        $this->payload = $url;
        return $this;
    }

    public $webview_height_ratio = WebviewSize::FULL;
    public $fallback_url;
    public $is_webview = false;
    public $is_webview_extended = false;

    public function webview($url, $size)
    {
        $this->url($url);
        $this->webview_height_ratio = $size;
        $this->is_webview = true;
        return $this;
    }

    public function webview_with_extensions($url, $size, $fallback = null)
    {
        $this->webview($url, $size);
        $this->fallback_url = $fallback;
        $this->is_webview_extended = true;
        return $this;
    }


    public function phone_number($number)
    {
        MessengerUtils::checkPhoneNumber($number);
        $this->type(ButtonType::PhoneNumber);
        $this->payload = $number;
        return $this;
    }

    //only for a generic template
    public function share()
    {
        $this->type(ButtonType::Share);
        //TODO remove title if set
        return $this;
    }

    public function link_account($callback_url)
    {
        $this->type(ButtonType::AccountLink);
        $this->payload = $callback_url;
        return $this;
    }

    public function unlink_account()
    {
        $this->type(ButtonType::AccountUnlink);
        return $this;
    }

    public function __construct()
    {

    }

    public static function create()
    {
        return new static();
    }

    public function toArray()
    {
        $payload_name = ($this->type == ButtonType::Web || $this->type == ButtonType::AccountLink) ? 'url' : 'payload';

        if ($this->type == ButtonType::AccountLink) {
            return [
                'type' => $this->type,
                'url' => $this->payload
            ];
        }

        if ($this->type == ButtonType::AccountUnlink) {
            return [
                'type' => $this->type
            ];
        }

        if ($this->is_webview) {
            $result = [
                'type' => $this->type,
                $payload_name => $this->payload,
                'title' => MessengerUtils::checkStringLengthAndEncoding($this->title, 320, 'UTF-8'),
                'webview_height_ratio' => $this->webview_height_ratio
            ];
            if ($this->is_webview_extended) {
                $result['messenger_extensions'] = true;
                if (!is_null($this->fallback_url)) {
                    $result['fallback_url'] = $this->fallback_url;
                }
            }

            return $result;
        }

        return [
            'type' => $this->type,
            $payload_name => $this->payload,
            'title' => MessengerUtils::checkStringLengthAndEncoding($this->title, 320, 'UTF-8'),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

}