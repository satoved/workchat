<?php

namespace Mood\Enums;

use Mood\Exceptions\HitLowerMoodBoundary;
use Mood\Exceptions\HitUpperMoodBoundary;

enum Mood
{
    case veryBad;
    case bad;
    case normal;
    case good;

    public function raise(): self
    {
        return match ($this) {
            self::veryBad => self::bad,
            self::bad => self::normal,
            self::normal => self::good,
            self::good => throw new HitUpperMoodBoundary(),
            default => throw new DomainException('Unknown mood'),
        };
    }

    public function lower(): self
    {
        return match ($this) {
            self::good => self::normal,
            self::normal => self::bad,
            self::bad => self::veryBad,
            self::veryBad => throw new HitLowerMoodBoundary(),
            default => throw new DomainException('Unknown mood'),
        };
    }

    public function explain()
    {
        return match ($this) {
            self::good => "I'm so proud of you",
            self::normal => "You can do better",
            self::bad => "OMG, go refactor it",
            self::veryBad => "Asta la vista, loser",
            default => throw new DomainException('Unknown mood'),
        };
    }
}