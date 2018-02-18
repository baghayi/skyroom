<?php
namespace Baghayi\Skyroom\Factory;

use Baghayi\Skyroom\Room as RoomItself;
use Baghayi\Skyroom\User;
use Baghayi\Skyroom\Collection\Users;
use Baghayi\Skyroom\Exception\AlreadyExists;
use Baghayi\Skyroom\Request;
use Baghayi\Skyroom\Exception\DuplicateRoom;

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
                'name'  => 'room-' . md5($name) . '-' . rand(1, 99999999),
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

