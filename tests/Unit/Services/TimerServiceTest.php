<?php
namespace App\Tests\Unit\Services;

use App\Entities\Shift;
use App\Entities\Staff;
use App\Models\Shift as ShiftModel;
use App\Services\TimerService;
use DateTime;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TimerServiceTest extends TestCase
{
    public function testWorkHours()
    {
        $timerService = new TimerService();

        $shift = new Collection(
            [
                new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['workhours' => 8]))
            ]
        );
        $this->assertEquals(8,$timerService->workHours($shift));

    }

    public function testCheckShifts()
    {
        $timerService = new TimerService();
        $shifts = new Collection([
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '10:00:00', 'endtime' => '18:00:00'])),
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '10:05:00', 'endtime' => '18:00:00']))
        ]);
        $this->assertEquals(5,$timerService->checkShifts($shifts));

        $shifts = new Collection([
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '10:00:00', 'endtime' => '18:00:00'])),
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '10:05:00', 'endtime' => '18:00:00'])),
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '11:05:00', 'endtime' => '18:02:00']))
        ]);
        $this->assertEquals(7,$timerService->checkShifts($shifts));


        $shifts = new Collection([
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '10:00:00', 'endtime' => '12:00:00'])),
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '11:00:00', 'endtime' => '18:00:00'])),
            new Shift(new Staff(0), (new ShiftModel())->setRawAttributes(['starttime' => '12:25:00', 'endtime' => '18:02:00']))
        ]);
        $this->assertEquals(87,$timerService->checkShifts($shifts));
    }

    public function testStringToTime()
    {
        $dateStart = '10:00:00';
        $dateEnd = '11:00:00';
        $timerService = new TimerService();
        $this->assertEquals([ new DateTime($dateStart), new DateTime($dateEnd)],$timerService->stringToTime($dateStart,$dateEnd));
    }

    public function testGetAlloneTimeFrames()
    {
        $shiftOne =[new DateTime('10:00:00'), new DateTime('18:00:00')];
        $shiftTwo = [new DateTime('11:00:00'), new DateTime('18:00:00')];
        $expecting[0] = [new DateTime('10:00:00'), new DateTime('11:00:00')];
        $timerService = new TimerService();
        $timeframe = $timerService->getAloneTimeFrames($shiftOne,$shiftTwo);
        $this->assertEquals($expecting,$timeframe);

        $shiftOne =[new DateTime('11:00:00'), new DateTime('18:00:00')];
        $shiftTwo = [new DateTime('11:00:00'), new DateTime('16:00:00')];
        $expecting[0] = [new DateTime('16:00:00'), new DateTime('18:00:00')];
        $timeframe = $timerService->getAloneTimeFrames($shiftOne,$shiftTwo);
        $this->assertEquals($expecting,$timeframe);

    }
}