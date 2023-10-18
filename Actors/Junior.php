<?php

namespace Actors;

use Chat\Traits\CanTalkInChat;
use Actors\TeamLead;
use Work\WorkResult;
use Work\Enums\WorkResultType;

class Junior
{
    use CanTalkInChat;

    public function __construct(
        private TeamLead $teamlead
    ) {
    }

    public static function under(TeamLead $teamlead): self
    {
        return new self(
            teamlead: $teamlead
        );
    }

    public function work(): void
    {
        $this->teamlead->deliver(
            new WorkResult($this, $this->tryToDeliver())
        );
    }

    protected function tryToDeliver(): WorkResultType
    {
        if (mt_rand(0, 1)) {
            // Junior got lucky and did his job successfully
            $this->writeMessage('Wow, I did it :)');

            return WorkResultType::success;
        }

        $this->writeMessage('Oh, I failed :(');

        return WorkResultType::failure;
    }

    public function name(): string
    {
        return 'Junior';
    }
}