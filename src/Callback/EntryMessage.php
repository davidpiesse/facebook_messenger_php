<?php

namespace mapdev\FacebookMessenger\Callback;

//use mapdev\FacebookMessenger\Callback\AccountLinking;
//use mapdev\FacebookMessenger\Callback\Authentication;
use mapdev\FacebookMessenger\Helper;
//use mapdev\FacebookMessenger\Callback\Message;
//use mapdev\FacebookMessenger\Callback\Postback;

class EntryMessage
{
    private $_message;
    private $useCarbonDT = false;

    public $sender_id;
    public $recipient_id;
    public $timestamp;

    public $isRead = false;
    public $isDelivered = false;
    public $isAuthentication = false;
    public $isAccountLinking = false;
    public $isPostback = false;
    public $isEcho = false;
    public $isMessage = false;

    /**
     * Message constructor.
     * @param $message
     * @boolean Use Carbon DateTime
     * Input of a message object (array)
     */
    public function __construct($message, $useCarbonDate = false)
    {
        $this->_message = $message;
        $this->sender_id = Helper::array_find($message, 'sender.id');
        $this->sender_id = Helper::array_find($message, 'sender.id');
        $this->recipient_id = Helper::array_find($message, 'recipient.id');
        $this->timestamp = Helper::array_find($message, 'timestamp');
        $this->useCarbonDT = $useCarbonDate;
        if ($this->useCarbonDT)
            $this->datetime = \Carbon\Carbon::createFromTimestamp($this->timestamp / 1000); //if  needed
        $this->updateRead();
        $this->updateDelivered();
        $this->updateAccountLinking();
        $this->updateAuthentication();
        $this->updatePostback();
        $this->updateMessage();
        $this->updateEcho();
    }

    private function updateRead()
    {
        $this->isRead = (!is_null(Helper::array_find($this->_message, 'read')));
        if ($this->isRead)
            $this->read = new Read(Helper::array_find($this->_message, 'read'), $this->useCarbonDT);
    }

    private function updateDelivered()
    {
        $this->isDelivered = (!is_null(Helper::array_find($this->_message, 'delivery')));
        if ($this->isDelivered)
            $this->delivery = new Delivered(Helper::array_find($this->_message, 'delivery'), $this->useCarbonDT);
    }

    private function updateAccountLinking()
    {
        $this->isAccountLinking = (!is_null(Helper::array_find($this->_message, 'account_linking')));
        if ($this->isAccountLinking)
            $this->account_linking = new AccountLinking(Helper::array_find($this->_message, 'account_linking'));
    }

    private function updateAuthentication()
    {
        $this->isAuthentication = (!is_null(Helper::array_find($this->_message, 'authentication')));
        if ($this->isAuthentication)
            $this->authentication = new Authentication(Helper::array_find($this->_message, 'authentication'));
    }

    private function updatePostback()
    {
        $this->isPostback = (!is_null(Helper::array_find($this->_message, 'postback')));
        if ($this->isPostback)
            $this->postback = new Postback(Helper::array_find($this->_message, 'postback'));
    }

//ONLY run after message
    private function updateEcho()
    {
        $this->isEcho = (!is_null(Helper::array_find($this->_message, 'is_echo')));
        if ($this->isEcho) {
            if (isset($this->message)) {
                $this->message->app_id = Helper::array_find($this->_message, 'app_id');
                $this->message->metadata = Helper::array_find($this->_message, 'metadata');
                $this->message->mid = Helper::array_find($this->_message, 'mid');
                $this->message->seq = Helper::array_find($this->_message, 'seq');
            } else
                throw new \Exception('Message not yet created for Echo');
        }
    }

    private function updateMessage()
    {
        $this->isMessage = (!is_null(Helper::array_find($this->_message, 'message')));
        if ($this->isMessage) {
            $this->message = new Message(Helper::array_find($this->_message, 'message'));
        }
    }
}