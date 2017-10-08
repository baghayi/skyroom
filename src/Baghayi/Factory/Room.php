<?php
namespace Baghayi\Factory;

use Baghayi\Room as RoomValueObject;

final class Room extends Factory {

    public function create(string $name) : RoomValueObject
    {
        $response = $this->make('createRoom', [
            'name'  => 'room-' . md5($name),
            'title' => $name,
            'guest_login' => false,
                /*
                 *"op_login_first" => true,
                 *"max_users" => 1000
                 */
            ]);

        $result = json_decode($response->getBody(), true);

        if($result['ok'] == true) {
            return new RoomValueObject($result['result']);
        }

        // throw proper exceptions in case of any kinds of errors
    }
}

