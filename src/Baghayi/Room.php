<?php
namespace Baghayi;

use Baghayi\Factory\Room as RoomFactory;
use Baghayi\Collection\Users;
use Baghayi\Request;
use Baghayi\User;

final class Room {

    private $id;
    private $roomFactory;
    private $request;

    public function __construct(Request $request, int $roomId)
    {
        $this->id = $roomId;
        $this->request = $request;
    }

    public function id() : int
    {
        return $this->id;
    }

    public function users() : Users
    {
        //$users = $this->roomFactory->users($this->id);
        $result = $this->request->make('getRoomUsers', [
            'room_id' => $this->id,
        ]);

        $users = new Users();
        $users->setRoomId($this->id);

        array_map(function($user) use ($users) {
            $users[] = User::fromArray($user);
        }, $result);

        return $users;

        //$users->setRoomFactory($this->roomFactory);
        return $users;
    }

    public function setRoomFactory(RoomFactory $factory)
    {
        $this->roomFactory = $factory;
    }
}
