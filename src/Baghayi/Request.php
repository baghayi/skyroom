<?php
namespace Baghayi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Baghayi\Exception\AlreadyExists;

final class Request {

    private $correspondingErrorExceptions = [
        'The record already exists.' => AlreadyExists::class,
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
                'params' => json_encode($params),
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
        /**
         * Not a proper way of handling errors :(
         */
        $errorException = $this->correspondingErrorExceptions[$result['error_message']] ?? null;
        if(is_null($errorException)) {
            throw new \Exception($result['error_message'], $result['error_code']);
        }
        else {
            throw new $errorException($result['error_message'], $result['error_code']);
        }
    }
}
