<?php

namespace Chat\Traits;

use Chat\Chat;

trait CanTalkInChat
{
    private ?Chat $chat = null;

    abstract public function name(): string;

    public function joinChat(Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

    public function writeMessage(string $message): void
    {
        if (! $this->chat) {
            return;
        }

        $this->chat->write(
            name: $this->name(),
            message: $message
        );
    }
}