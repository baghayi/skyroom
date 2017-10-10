<?php
namespace Baghayi;

use Baghayi\Request;

final class User {

    const ACCESS_LEVEL_NORMAL     = 1;
    const ACCESS_LEVEL_PRESENTER  = 2;
    const ACCESS_LEVEL_OPERATOR   = 3;
    const ACCESS_LEVEL_ADMIN      = 4;

    private $id;
    private $username;
    private $nickname;
    private $accessLevel;
    private $request = null;

    public function __construct(int $userId, Request $request = null)
    {
        $this->request = $request;
        $this->id = $userId;
    }

    public function id() : int
    {
        return $this->id;
    }

    public function username()
    {
        return $this->username;
    }

    public function nickname()
    {
        return $this->nickname;
    }

    public function accessLevel()
    {
        return $this->accessLevel;
    }

    public function fromArray(array $data)
    {
        $user = new self($data['user_id']);
        $user->username = $data['username'];
        $user->nickname = $data['nickname'];
        $user->accessLevel = $data['access'];

        return $user;
    }

    public function update(array $data)
    {
        if(is_null($this->request)) {
            throw new \Exception('Request object is not provided as dependency!');
        }

        $result = $this->request->make('updateUser', array_merge($data, ['user_id' => $this->id()]));

        if($result == true) {
            array_walk($data, [$this, 'updateProperty']);
        }

        return $result;
    }

    private function updateProperty($value, $property)
    {
        if(!property_exists($this, $property)) {
            return;
        }

        $this->$property = $value;
    }

    public function loginUrl(Room $room, int $ttl = 60) : string
    {
        return $this->request->make('getLoginUrl', [
            'room_id' => $room->id(),
            'user_id' => $this->id,
            'ttl' => $ttl,
        ]);
    }
}
