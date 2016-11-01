<?php

namespace mapdev\FacebookMessenger\Traits;


use mapdev\FacebookMessenger\Enums\NotificationType;
use mapdev\FacebookMessenger\Exceptions\CouldNotCreateMessage;

/**
 * Class MessageTrait
 * @package mapdev\FacebookMessenger\Traits
 */
trait MessageTrait
{
    /**
     * @var
     * Recipient PSID
     */
    public $recipient_id;

    /**
     * @param $recipient_id
     * @return $this
     */
    public function to($recipient_id)
    {
        return $this->recipient_id($recipient_id);
    }

    /**
     * @param $recipient_id
     * @return $this
     */
    public function recipient_id($recipient_id)
    {
        $this->recipient_id = $recipient_id;
        return $this;
    }

    //TODO Check for ID or phone number
    public function checkRecipient()
    {
        if (!isset($this->recipient_id)) {
            throw CouldNotCreateMessage::noRecipientDefined();
        }
    }

    public $notification_type = NotificationType::REGULAR;

    /**
     * @param $notification_type
     * @return $this
     */
    public function notification_type($type)
    {
        $this->notification_type = $type;
        return $this;
    }

}