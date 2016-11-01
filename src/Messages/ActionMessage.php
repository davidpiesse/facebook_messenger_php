<?php

namespace mapdev\FacebookMessenger\Messages;

use mapdev\FacebookMessenger\Exceptions\CouldNotCreateMessage;
use mapdev\FacebookMessenger\Interfaces\MessageInterface;
use mapdev\FacebookMessenger\Traits\MessageTrait;
use mapdev\FacebookMessenger\Enums\ActionType;
use JsonSerializable;

class ActionMessage implements MessageInterface, JsonSerializable
{
    use MessageTrait;

    public $action;

    public function action($action)
    {
        $this->action = $action;
        return $this;
    }

    public function __construct($action = null)
    {
        $this->action($action);
    }

    public static function create($action = null)
    {
        return new static($action);
    }

    public function toArray()
    {
        $this->checkRecipient();

        if(is_null($this->action))
            throw CouldNotCreateMessage::noActionDefined();

        return [
            'recipient' => [
                'id' => $this->recipient_id
            ],
            'sender_action' => $this->action
        ];
        //return array
        //check null action
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}