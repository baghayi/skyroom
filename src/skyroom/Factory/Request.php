<?php
namespace Baghayi\Skyroom\Factory;

use GuzzleHttp\Client;
use Baghayi\Skyroom\Request as RequestItself;

final class Request {

    public function create(string $baseUri)
    {
        $http = new Client([
            'base_uri' => $baseUri,
        ]);

        return new RequestItself($http);
    }

}
