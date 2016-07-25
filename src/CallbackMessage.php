<?php
namespace mapdev\FacebookMessenger;

/**
 * Class CallbackMessage
 * @package mapdev\FacebookMessenger
 */
abstract class CallbackMessage
{
    /**
     * @var
     * The senders ID (User)
     */
    public $sender_id;
    /**
     * @var
     * The recipients ID (Bot/Page)
     */
    public $recipient_id;

    /**
     * CallbackMessage constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->sender_id = $message['sender']['id'];
        $this->recipient_id = $message['recipient']['id'];
    }
}