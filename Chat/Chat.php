<?php

namespace Chat;

use Chat\Data\ChatMessage;

class Chat
{
    public function __construct(
        private array $messages = [],
    ) {
    }

    public function write(string $name, string $message)
    {
        $this->messages[] = new ChatMessage(
            name: $name,
            message: $message
        );
    }

    public function asString(): string
    {
        return implode(
            "\n",
            array_map(fn($message) => $message->toString(), $this->messages)
        );
    }
}