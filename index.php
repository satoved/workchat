<?php

use Actors\HR;
use Actors\Junior;
use Actors\TeamLead;
use Chat\Chat;
use Mood\Enums\Mood;

require_once "Autoloader.php";
Autoloader::register();

$chat = new Chat();

$teamLead = TeamLead::wokeUpInMood(Mood::normal)->joinChat($chat);

$hr = (new HR())->joinChat($chat);

$teamLead->watchedBy([
    $hr,
]);

$junior = Junior::under($teamLead)->joinChat($chat);

foreach (range(1, 50) as $i) {
    $junior->work();
}

$hr->report();

echo $chat->asString();