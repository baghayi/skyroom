<?php
namespace Baghayi\Skyroom\Factory;

use Baghayi\Skyroom\User as UserItself;
use Baghayi\Skyroom\Request;

final class User {

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function register(array $data) : UserItself
    {
        $result = $this->request->make('createUser', [
            'username' => $data['username'],
            'nickname' => $this->nickname($data['first_name']),
            'password' => $data['password'],
            'email' => $data['email'],
            'fname' => $data['first_name'],
            'lname' => $data['last_name'],
            'is_public' => false,
        ]);

        return new UserItself($result, $this->request);
    }

    private function nickname($name)
    {
        return strlen($name) >= 3 ? $name : $name . rand(100, 999);
    }
}

