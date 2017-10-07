<?php
namespace Baghayi;

final class Room {

    private $id;

    public function __construct(int $roomId)
    {
        $this->id = $roomId;
    }

    public function id() : int
    {
        return $this->id;
    }
}
