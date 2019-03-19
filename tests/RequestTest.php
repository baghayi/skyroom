<?php

namespace tests;

use Baghayi\Skyroom\Request;
use GuzzleHttp\Client;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RequestTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
    * @test
    * @expectedException \Baghayi\Skyroom\Exception\NotFound
    */
    public function throws_exception_when_requested_resource_could_not_found()
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->allows()->getBody()->andReturns(json_encode([
            'ok' => false, 
            'error_code' => 15,
            'error_message' => 'داده‌ مورد نظر پیدا نشد.',
        ]));

        $http = Mockery::mock(Client::class);
        $http->allows()->request(Mockery::any(), Mockery::any(), Mockery::any())->andReturns($response);

        $roomIdWhichDoesNotExist = 119;
        $request = new Request($http);
        $request->make('getRoom', [
            'room_id' => $roomIdWhichDoesNotExist,
        ]);
    }
}
