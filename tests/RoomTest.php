<?php

namespace tests;

use Baghayi\Skyroom\Request;
use Baghayi\Skyroom\Room;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class RoomTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
    * @test
    */
    public function room_usage()
    {
        $usageInMinutes = 120;
        $request = Mockery::mock(Request::class);
        $request->allows()->make()->with(Mockery::any(), Mockery::any())->andReturns([
            'time_usage' => $usageInMinutes,
        ]);

        $roomId = 1;
        $room = new Room($roomId, $request);

        $this->assertEquals($usageInMinutes / 60, $room->usage()->toInt());
    }
}
