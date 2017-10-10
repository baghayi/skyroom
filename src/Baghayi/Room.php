<?php
namespace Baghayi;

use Baghayi\Collection\Users;
use Baghayi\Request;
use Baghayi\User;

final class Room {

    private $id;
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
        $result = $this->request->make('getRoomUsers', [
            'room_id' => $this->id,
        ]);

        $users = new Users();
        $users->setRoomId($this->id);
        $users->setRequest($this->request);

        array_map(function($user) use ($users) {
            $users[] = User::fromArray($user);
        }, $result);

        return $users;

        return $users;
    }

    public function url(bool $relative = false) : string
    {
        return $this->request->make('getRoomUrl', [
            'room_id' => $this->id,
            'relative' => $relative,
        ]);
    }

    public function update(array $data)
    {
        return $this->request->make('updateRoom', array_merge($data, ['room_id' => $this->id]));
    }
}
