<?php

namespace Reports;

class JuniorReport
{
    public function __construct(
        private int $rebukes = 0,
        private int $praises = 0
    ) {
    }

    public function countRebukes(): int
    {
        return $this->rebukes;
    }

    public function countPraises(): int
    {
        return $this->praises;
    }

    public function checkPraise(): void
    {
        $this->praises += 1;
    }

    public function checkRebuke(): void
    {
        $this->rebukes += 1;
    }

    public static function blank(): self
    {
        return new self(
            rebukes: 0,
            praises: 0,
        );
    }
}