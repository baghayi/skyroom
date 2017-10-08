<?php
namespace Baghayi;

final class User {

    private $id;

    public function __construct(int $userId)
    {
        $this->id = $userId;
    }

    public function id() : int
    {
        return $this->id;
    }

}
