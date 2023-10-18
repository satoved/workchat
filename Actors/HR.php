<?php

namespace Actors;

use Chat\Traits\CanTalkInChat;
use Actors\Junior;
use Reports\JuniorReport;
use Mood\Contracts\MoodWatcher;
use WeakMap;

class HR implements MoodWatcher
{
    use CanTalkInChat;

    private WeakMap $juniorsUnderControl;

    public function __construct()
    {
        $this->juniorsUnderControl = new WeakMap();
    }

    public function notifyAboutRebukeFor(Junior $junior)
    {
        if (! isset($this->juniorsUnderControl[$junior])) {
            $this->juniorsUnderControl[$junior] = JuniorReport::blank();
        }

        $this->juniorsUnderControl[$junior]->checkRebuke();
    }

    public function notifyAboutPraiseFor(Junior $junior)
    {
        if (! isset($this->juniorsUnderControl[$junior])) {
            $this->juniorsUnderControl[$junior] = JuniorReport::blank();
        }

        $this->juniorsUnderControl[$junior]->checkPraise();
    }

    public function name(): string
    {
        return 'HR';
    }

    public function report(): void
    {
        foreach ($this->juniorsUnderControl as $junior => $report) {
            $this->writeMessage("{$junior->name()} was rebuked {$report->countRebukes()} times and praised {$report->countPraises()} times");
        }
    }
}