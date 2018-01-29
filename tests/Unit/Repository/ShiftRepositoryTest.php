<?php
namespace App\Tests\Unit\Repository;

use App\Entities\Day;
use App\Models\Shift as ShiftModel;
use App\Repository\ShiftRepository;
use App\Services\TimerService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShiftRepositoryTest extends TestCase{

    public function testConstruct()
    {
        $shiftModel = $this->getMockBuilder(ShiftModel::class)->getMock();
        $timerService = $this->getMockBuilder(TimerService::class)->getMock();
        $shiftRepo = new ShiftRepository($shiftModel, $timerService);
        $this->assertInstanceOf(ShiftRepository::class, $shiftRepo);
    }
    public function testCreateDays(){
        $shiftModel = $this->getMockBuilder(ShiftModel::class)->getMock();
        $timerService = $this->getMockBuilder(TimerService::class)->getMock();
        $shiftRepo = new ShiftRepository($shiftModel, $timerService);
        $day = $shiftRepo->createDays([(new ShiftModel())->setRawAttributes(['staffid' => 1, 'daynumber' => 0])]);
        $this->assertInstanceOf(Day::class, $day[0]);
    }

    public function testMutators()
    {
        $shiftModel = $this->getMockBuilder(ShiftModel::class)->setMethods(['getEmployeesShifts'])->getMock();
        $timerService = $this->getMockBuilder(TimerService::class)->getMock();
        $shiftModel->expects($this->once())->method('getEmployeesShifts')->willReturn(new Collection([(new ShiftModel())->setRawAttributes(['staffid' => 1, 'daynumber' => 0])]));
        $shiftRepo = new ShiftRepository($shiftModel, $timerService);
        $result = $shiftRepo->getDaysShifts();
        $this->assertInstanceOf(Day::class, $result[0]);
        $expected= [0=> 1, 1 => 55];
        $shiftModelSecond = $this->getMockBuilder(ShiftModel::class)->setMethods(['getEmployeeIds'])->getMock();
        $shiftModelSecond->expects($this->once())->method('getEmployeeIds')->willReturn($expected);        $shiftRepoSecond = new ShiftRepository($shiftModelSecond, $timerService);

        $this->assertEquals($expected,$shiftRepoSecond->getStaffIds());
    }


}