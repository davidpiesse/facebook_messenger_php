<?php
namespace mapdev\FacebookMessenger;

class ButtonTemplate implements TemplateInterface
{
    protected $text;
    protected $buttons = [];

    public function __construct($text, $buttons)
    {
        $this->text = MessengerUtils::checkStringEncoding(MessengerUtils::checkStringLength($text,320),'UTF-8');
        $this->buttons = MessengerUtils::checkArraySize($buttons,3);
    }

    public function toData()
    {
        return [
            'message' => [
                'attachment'=>[
                    'type' => 'template',
                    'payload' =>[
                        'template_type' => 'button',
                        'text' => $this->text,
                        'buttons' => collect($this->buttons)->map(function($item){
                            return $item->toData();
                        })
                    ]
                ]
            ]
        ];
    }
}