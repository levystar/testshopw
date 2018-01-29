<?php
/**
 * Created by PhpStorm.
 * User: dude
 * Date: 1/29/2018
 * Time: 11:53 AM
 */
namespace App\Tests\Unit\Entities;

use App\Entities\Day;
use App\Entities\Shift;
use App\Entities\Staff;
use App\Services\TimerService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DayTest extends TestCase
{
    public function testConstruct()
    {
        $timeService = $this->getMockBuilder(TimerService::class)->getMock();
        $day = new Day(1, $timeService);

        $this->assertInstanceOf(Day::class, $day);
        $this->assertEquals(new Collection([]), $day->getShifts());
    }

    public function testAddShift()
    {
        $timeService = $this->getMockBuilder(TimerService::class)->getMock();
        $day = new Day(1, $timeService);
        $shift = $this->getMockBuilder(Shift::class)->disableOriginalConstructor()->getMock();
        $day->addShift($shift);
        $this->assertEquals(new Collection([$shift]), $day->getShifts());
    }
    public function testMutator()
    {
        $timeService = $this->getMockBuilder(TimerService::class)->getMock();
        $day = new Day(1, $timeService);
        $day->setDay(0);
        $shift = new Shift(new Staff(1), new \App\Models\Shift());
        $day->setShifts(new Collection([$shift]));

        $this->assertEquals($shift, $day->getShiftForEmployee(1));
        $this->assertEquals(0, $day->getTotalHours());
        $this->assertEquals(0, $day->getMinutesWorkedAlone());
        $this->assertEquals(new Collection([$shift]), $day->getShifts());
        $this->assertEquals(0, $day->getDay());



    }
}