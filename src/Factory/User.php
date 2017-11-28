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
            'nickname' => $data['first_name'],
            'password' => $data['password'],
            'email' => $data['email'],
            'fname' => $data['first_name'],
            'lname' => $data['last_name'],
            'is_public' => false,
        ]);

        return new UserItself($result, $this->request);
    }
}

