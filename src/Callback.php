<?php
namespace mapdev\FacebookMessenger;

//provides common fields, constructor and functions required
class Callback
{

    //request?
    public $object;
    protected $entry;
    public $id;
    public $time;
    public $messaging = [];
    public $messages = [];


    public function __construct($data)
    {
        $this->object = $data['object'];
        $this->entry = $data['entry'][0];
        $this->id = $data['entry'][0]['id'];
        $this->time = $data['entry'][0]['time'];
        $this->messaging = $data['entry'][0]['messaging'];
        //get all messages as objects
        $this->messages = collect($this->messaging)->map(function($message){
            if(isset($message['message']))
                return new MessageReceived($message);
            if(isset($message['postback']))
                return new PostbackReceived($message);
            if(isset($message['delivery']))
                return new MessageDelivered($message);
            if(isset($message['read']))
                return new MessageRead($message);
            if(isset($message['optin']))
                return new AuthenticationOptin($message);
            if(isset($message['account_linking']))
                return new AccountLinking($message);
            //catch all?
        });
    }

    public function isValid()
    {
        return true;
    }

    //object
    //entry
    //id
    //time
    //messaging
}