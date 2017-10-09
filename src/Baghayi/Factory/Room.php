<?php
namespace Baghayi\Factory;

use Baghayi\Room as RoomItself;
use Baghayi\User;
use Baghayi\Collection\Users;
use Baghayi\Exception\AlreadyExists;
use Baghayi\Request;

final class Room {

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create(string $name) : RoomItself
    {
        $result = $this->request->make('createRoom', [
            'name'  => 'room-' . md5($name),
            'title' => $name,
            'guest_login' => false,
                /*
                 *"op_login_first" => true,
                 *"max_users" => 1000
                 */
            ]);

        $room = new RoomItself($this->request, $result);
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

    public function detachUser(int $roomId, User $user) : bool
    {
        $result = $this->make('removeRoomUsers', [
            'room_id' => $roomId,
            'users' => [$user->id()]
        ]);

        return $result;
    }

}

