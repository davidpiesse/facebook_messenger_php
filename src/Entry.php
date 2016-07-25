<?php

namespace mapdev\FacebookMessenger;

class Entry
{
    public $id;
    public $time;
    public $messages;
    private $_messaging;

    /**
     * Entry constructor.
     * @param $entry
     * entry array object
     */
    public function __construct($entry)
    {
        $this->id = Helper::array_find($entry, 'id');
        $this->time = Helper::array_find($entry, 'time');
        $this->_messaging = Helper::array_find($entry, 'messaging');
        $this->buildMessages();
    }

    private function buildMessages()
    {
        $this->messages = collect($this->_messaging)->map(function ($message) {
            return new EntryMessage($message);
        });
    }
}