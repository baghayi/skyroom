<?php
namespace Baghayi\Factory;

use Baghayi\Room as RoomValueObject;
use Baghayi\User;
use Baghayi\Collection\Users;

final class Room extends Factory {

    public function create(string $name) : RoomValueObject
    {
        $response = $this->make('createRoom', [
            'name'  => 'room-' . md5($name),
            'title' => $name,
            'guest_login' => false,
                /*
                 *"op_login_first" => true,
                 *"max_users" => 1000
                 */
            ]);

        $result = json_decode($response->getBody(), true);

        if($result['ok'] == true) {
            $room = new RoomValueObject($result['result']);
            $room->setRoomFactory($this);
            return $room;
        }

        // throw proper exceptions in case of any kinds of errors
    }

    public function users(int $roomId) : Users
    {
        $response = $this->make('getRoomUsers', [
            'room_id' => $roomId,
        ]);

        $result = json_decode($response->getBody(), true);

        if($result['ok'] == true) {
            $users = new Users();
            array_map(function($user) use ($users) {
                $users[] = User::fromArray($user);
            }, $result['result']);
            return $users;
        }

        // throw proper exceptions in case of any kinds of errors
    }
}

