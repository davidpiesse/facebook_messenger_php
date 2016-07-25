<?php

namespace mapdev\FacebookMessenger;

//TODO Only add in as required later on
class MessageManager extends Collection
{

    public function addMessage(EntryMessage $message)
    {
        $this->add($message);
    }

    public function getPreviousMessage(EntryMessage $current_message)
    {
//go through messages and find the one that was last in sequence
    }

    public function getLastUserMessage($user_id)
    {
        return $this->where('sender_id', $user_id)
            ->orderBy('timestamp', 'desc')
            ->first();
    }

    public function getLastSystemMessage($system_id)
    {
        return $this->where('sender_id', $system_id)
            ->orderBy('timestamp', 'desc')
            ->first();
    }

    public function getLastActivityDateTime($user_id)
    {
//get the most recent timestamp for any message by a user (id)
        return $this->where('sender_id', $user_id)
            ->orderBy('timestamp', 'desc')
            ->select('timestamp');
    }
}