<?php
namespace Baghayi\Collection;

use Baghayi\User;
use Baghayi\Request;

class Users extends \ArrayObject
{
    private $roomId;
    private $request;

    public function setRoomId(int $roomId)
    {
        $this->roomId = $roomId;
    }

    public function attach(User $user, int $accessLevel) : bool
    {
        if(is_null($this->roomId)) {
            throw new \Exception('Users are not bound to any room!');
        }

        $result = $this->request->make('addRoomUsers', [
            'room_id' => $this->roomId,
            'users' => [
                ['user_id' => $user->id(), 'access' => $accessLevel]
            ]
        ]);

        return $result;
    }

    public function detach(User $user) : bool
    {
        if(is_null($this->roomId)) {
            throw new \Exception('Users are not bound to any room!');
        }

        $result = $this->request->make('removeRoomUsers', [
            'room_id' => $this->roomId,
            'users' => [$user->id()]
        ]);

        return $result;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
}
