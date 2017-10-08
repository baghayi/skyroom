<?php
namespace Baghayi;

use Baghayi\Factory\Room as RoomFactory;
use Baghayi\Collection\Users;

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

    public function users() : Users
    {
        $users = $this->roomFactory->users($this->id);
        $users->setRoomFactory($this->roomFactory);
        return $users;
    }

    public function setRoomFactory(RoomFactory $factory)
    {
        $this->roomFactory = $factory;
    }
}
