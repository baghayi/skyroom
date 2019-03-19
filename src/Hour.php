<?php
namespace Baghayi\Skyroom;

final class Hour
{
    private $totalHours;

    public function __construct(int $totalHours)
    {
        $this->totalHours = $totalHours;
    }

    public function toInt(): int
    {
        return $this->totalHours;
    }
}
