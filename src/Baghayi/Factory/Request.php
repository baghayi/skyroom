<?php
namespace Baghayi\Factory;

use GuzzleHttp\Client;
use Baghayi\Request as RequestItself;

final class Request {

    public function create(string $baseUri)
    {
        $http = new Client([
            'base_uri' => $baseUri,
        ]);

        return new RequestItself($http);
    }

}
