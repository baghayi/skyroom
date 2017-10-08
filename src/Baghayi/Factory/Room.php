<?php
namespace Baghayi\Factory;

use Baghayi\Room as RoomValueObject;
use Baghayi\User;
use Baghayi\Collection\Users;
use Baghayi\Exception\AlreadyExists;

final class Room extends Factory {

    public function create(string $name) : RoomValueObject
    {
        $result = $this->make('createRoom', [
            'name'  => 'room-' . md5($name),
            'title' => $name,
            'guest_login' => false,
                /*
                 *"op_login_first" => true,
                 *"max_users" => 1000
                 */
            ]);

        $room = new RoomValueObject($result);
        $room->setRoomFactory($this);
        return $room;
    }

    public function users(int $roomId) : Users
    {
        $result = $this->make('getRoomUsers', [
            'room_id' => $roomId,
        ]);

        $users = new Users();
        $users->setRoomId($roomId);

        array_map(function($user) use ($users) {
            $users[] = User::fromArray($user);
        }, $result);

        return $users;
    }

    public function attachUser(int $roomId, User $user, int $accessLevel) : bool
    {
        $result = $this->make('addRoomUsers', [
            'room_id' => $roomId,
            'users' => [
                ['user_id' => $user->id(), 'access' => $accessLevel]
            ]
        ]);

        return $result;
    }

}

