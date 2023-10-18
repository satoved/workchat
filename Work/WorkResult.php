<?php

namespace Work;

use Actors\Junior;
use Work\Enums\WorkResultType;

class WorkResult
{
    public function __construct(
        public readonly Junior $executor,
        public readonly WorkResultType $resultType,
    ) {
    }

    public function isFailed(): bool
    {
        return $this->resultType === WorkResultType::failure;
    }

    public function isSuccessful(): bool
    {
        return $this->resultType === WorkResultType::success;
    }
}