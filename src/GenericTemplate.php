<?php
namespace mapdev\FacebookMessenger;

class GenericTemplate implements TemplateInterface
{

    public $elements=[];

    public function __construct(array $elements)
    {
        $this->elements = MessengerUtils::checkArraySize($elements,10);
    }

    public function toData()
    {
        return [
            'message' => [
                'attachment'=>[
                    'type' => 'template',
                    'payload' =>[
                        'template_type' => 'generic',
                        'elements' => collect($this->elements)->map(function($item){
                            return $item->toData();
                        })
                    ]
                ]
            ]
        ];
    }
}