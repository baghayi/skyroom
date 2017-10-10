<?php
namespace Baghayi\Factory;

use GuzzleHttp\Client;

final class GuzzleClient {

    public function create(string $baseUri)
    {
        return new Client([
            'base_uri' => $baseUri,
        ]);
    }

}
