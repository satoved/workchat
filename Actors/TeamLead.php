<?php

namespace Actors;

use Chat\Traits\CanTalkInChat;
use Mood\Contracts\MoodWatcher;
use Mood\Enums\Mood;
use Mood\Exceptions\HitLowerMoodBoundary;
use Mood\Exceptions\HitUpperMoodBoundary;
use Work\WorkResult;

class TeamLead
{
    use CanTalkInChat;

    private array $watchers = [];

    public function __construct(
        private Mood $mood
    ) {
    }

    public static function wokeUpInMood(Mood $mood): self
    {
        return new self($mood);
    }

    public function watchedBy(array $watchers)
    {
        foreach ($watchers as $watcher) {
            if (! $watcher instanceof MoodWatcher) {
                throw new DomainException('Only MoodWatchers can watch');
            }
        }

        $this->watchers = $watchers;
    }

    public function deliver(WorkResult $workResult)
    {
        $this->changeMoodBasedOnWorkDone($workResult);
        $this->expressMood();
    }

    private function raiseMoodBy(WorkResult $workResult)
    {
        try {
            $this->mood = $this->mood->raise();
        } catch (HitUpperMoodBoundary) {
            $this->notifyWatchersAboutPraise($workResult);
        }
    }

    private function lowerMoodBy(WorkResult $workResult)
    {
        try {
            $this->mood = $this->mood->lower();
        } catch (HitLowerMoodBoundary) {
            $this->notifyWatchersAboutRebuke($workResult);
        }
    }

    protected function notifyWatchersAboutPraise(WorkResult $workResult): void
    {
        foreach ($this->watchers as $watcher) {
            /** @var \Mood\Contracts\MoodWatcher $watcher */
            $watcher->notifyAboutPraiseFor($workResult->executor);
        }
    }

    protected function notifyWatchersAboutRebuke(WorkResult $workResult): void
    {
        foreach ($this->watchers as $watcher) {
            /** @var \Mood\Contracts\MoodWatcher $watcher */
            $watcher->notifyAboutRebukeFor($workResult->executor);
        }
    }

    public function name(): string
    {
        return 'Terminator T-70';
    }

    private function expressMood(): void
    {
        $this->writeMessage($this->mood->explain());
    }

    protected function changeMoodBasedOnWorkDone(WorkResult $workResult): void
    {
        if ($workResult->isSuccessful()) {
            $this->raiseMoodBy($workResult);

            return;
        }

        if ($workResult->isFailed()) {
            $this->lowerMoodBy($workResult);

            return;
        }

        throw new WorkResultUnidentifiable();
    }
}