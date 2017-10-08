<?php
namespace Baghayi\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

abstract class Factory {

    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function make(string $action, array $params) : Response
    {
        return $this->http->request('POST', null, [
            'json' => [
                'action' => $action,
                'params' => json_encode($params),
            ],
        ]);
    }
}
