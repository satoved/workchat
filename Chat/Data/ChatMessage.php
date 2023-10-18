<?php

namespace Chat\Data;

class ChatMessage
{
    public function __construct(
        public readonly string $name,
        public readonly string $message,
    ) {
    }

    public function toString(): string
    {
        return "$this->name: $this->message";
    }
}