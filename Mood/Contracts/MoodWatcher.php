<?php

namespace Mood\Contracts;

use Actors\Junior;

interface MoodWatcher
{
    public function notifyAboutRebukeFor(Junior $junior);

    public function notifyAboutPraiseFor(Junior $junior);
}