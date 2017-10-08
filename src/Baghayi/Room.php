<?php
namespace Baghayi;

use Baghayi\Factory\Room as RoomFactory;

final class Room {

    private $id;
    private $roomFactory;

    public function __construct(int $roomId)
    {
        $this->id = $roomId;
    }

    public function id() : int
    {
        return $this->id;
    }

    public function users()
    {
        return $this->roomFactory->users($this->id);
    }

    public function setRoomFactory(RoomFactory $factory)
    {
        $this->roomFactory = $factory;
    }
}
