<?php
namespace Baghayi\Factory;

use Baghayi\Room as RoomItself;
use Baghayi\User;
use Baghayi\Collection\Users;
use Baghayi\Exception\AlreadyExists;
use Baghayi\Request;
use Baghayi\Exception\DuplicateRoom;

final class Room {

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create(string $name) : RoomItself
    {
        try {
            $roomId = $this->request->make('createRoom', [
                'name'  => 'room-' . md5($name),
                'title' => $name,
                'guest_login' => false,
                /*
                 *"op_login_first" => true,
                 *"max_users" => 1000
                 */
                ]);
        }
        catch(DuplicateRoom $e) {
            $name .= '-' . rand(1, 99999999);
            return $this->create($name);
        }

        $room = new RoomItself($roomId, $this->request);
        return $room;
    }

}

