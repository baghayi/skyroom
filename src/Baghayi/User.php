<?php
namespace Baghayi;

final class User {

    const ACCESS_LEVEL_NORMAL     = 1;
    const ACCESS_LEVEL_PRESENTER  = 2;
    const ACCESS_LEVEL_OPERATOR   = 3;
    const ACCESS_LEVEL_ADMIN      = 4;

    private $id;
    private $username;
    private $nickname;
    private $accessLevel;

    public function __construct(int $userId)
    {
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
        $this->nickname;
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
}
