<?php
namespace mapdev\FacebookMessenger;

use mapdev\FacebookMessenger\Callback\Entry;
use mapdev\FacebookMessenger\Callback\EntryMessage;

class Callback
{

    public $object;
    public $entries = [];
    private $_entries = [];

    /**
     * Cb constructor.
     * @param $data
     * An array of request information $request->all()
     */
    public function __construct($data)
    {
        $this->object = Helper::array_find($data, 'object');
        $this->_entries = Helper::array_find($data, 'entry');
        $this->buildEntries();
    }

    public static function create($data)
    {
        return new static($data);
    }

    private function buildEntries()
    {
        $this->entries = collect($this->_entries)->map(function ($entry) {
            return new Entry($entry);
        });
    }

    //TODO refactor into collections each/map/filter
    //map then filter (double isMessage & isText)
    //Not Quick Replies
    public function textMessages()
    {
        $result = [];
        foreach ($this->entries as $entry) {
            foreach ($entry->messages as $entryMessage) {
                if ($entryMessage->isMessage) {
                    if ($entryMessage->message->isText && !$entryMessage->message->isQuickReply) {
                        $result[] = $entryMessage;
                    }
                }
            }
        }
        return collect($result);
    }

    public function quickreplies()
    {
        $result = [];
        foreach ($this->entries as $entry) {
            foreach ($entry->messages as $entryMessage) {
                if ($entryMessage->isMessage) {
                    if ($entryMessage->message->isQuickReply) {
                        $result[] = $entryMessage;
                    }
                }
            }
        }
        return collect($result);
    }

//TODO refactor into collections each/map/filter
    public function postbackMessages()
    {
        $result = [];
        foreach ($this->entries as $entry) {
            foreach ($entry->messages as $entryMessage) {
                if ($entryMessage->isPostback) {
                    $result[] = $entryMessage;
                }
            }
        }
        return collect($result);
    }

//TODO refactor into collections each/map/filter
    public function attachmentMessages()
    {
        $result = [];
        foreach ($this->entries as $entry) {
            foreach ($entry->messages as $entryMessage) {
                if ($entryMessage->isMessage) {
                    if ($entryMessage->message->hasAttachments) {
                        $result[] = $entryMessage->message;
                    }
                }
            }
        }
        return collect($result);
    }
}