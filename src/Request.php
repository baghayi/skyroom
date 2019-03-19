<?php
namespace Baghayi\Skyroom;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Baghayi\Skyroom\Exception\AlreadyExists;
use Baghayi\Skyroom\Exception\AccessDenied;
use Baghayi\Skyroom\Exception\DuplicateRoom;
use Baghayi\Skyroom\Exception\UnavailableUsername;
use Baghayi\Skyroom\Exception\InvalidRoomName;

class Request
{
    const ERROR_CODES = [
        15 => Exception\NotFound::class,
    ];

    private $correspondingErrorExceptions = [
        'The record already exists.' => AlreadyExists::class,
        'User has no access to the room' => AccessDenied::class,
        'Access to the resource is denied.' => AccessDenied::class,
        'اتاقی با همین نام وجود دارد. از نام دیگری استفاده نمایید.' => DuplicateRoom::class,
        'نام کاربری تکراری است' => UnavailableUsername::class,
        'نام اتاق معتبر نیست.' => InvalidRoomName::class,
    ]; 

    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function make(string $action, array $params)
    {
        $response = $this->http->request('POST', null, [
            'json' => [
                'action' => $action,
                'params' => $params,
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if($result['ok'] === true) {
            return $result['result'];
        }

        $this->handleErrors($result);
    }

    private function handleErrors(array $result)
    {
        $errorException = self::ERROR_CODES[$result['error_code']] ?? null;
        if (!is_null($errorException)) {
            throw new $errorException($result['error_message']);
        }

        /**
         * Not a proper way of handling errors :(
         */
        $errorException = null;
        foreach($this->correspondingErrorExceptions as $error => $class) {
            if(false != strstr($result['error_message'], $error)) {
                $errorException = $class;
                break;
            }
        }

        if(is_null($errorException)) {
            throw new \Exception($result['error_message'], $result['error_code']);
        }
        else {
            throw new $errorException($result['error_message'], $result['error_code']);
        }
    }
}
