<?php
namespace Baghayi\Collection;

use Baghayi\User;
use Baghayi\Factory\Room as RoomFactory;

class Users extends \ArrayObject
{
    private $roomId;
    private $roomFactory;

    public function setRoomId(int $roomId)
    {
        $this->roomId = $roomId;
    }

    public function attach(User $user, int $accessLevel) : bool
    {
        if(is_null($this->roomId)) {
            throw new \Exception('Users are not bound to any room!');
        }

        return $this->roomFactory->attachUser($this->roomId, $user, $accessLevel);
    }

    public function detach(User $user) : bool
    {
        if(is_null($this->roomId)) {
            throw new \Exception('Users are not bound to any room!');
        }

        return $this->roomFactory->detachUser($this->roomId, $user);
    }

    public function setRoomFactory(RoomFactory $factory)
    {
        $this->roomFactory = $factory;
    }
}
