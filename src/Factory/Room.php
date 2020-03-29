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

    public function create(string $name, int $max_users = null) : RoomItself
    {
        try {
            $roomId = $this->request->make('createRoom', [
                'name'  => 'room-' . md5($name) . '-' . rand(1, 99999999),
                'title' => mb_substr($name, 0, 128),
                'guest_login' => false,
                "max_users" => $max_users
                /*
                 *"op_login_first" => true,
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

