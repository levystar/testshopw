<?php
namespace App\Tests\Unit\Entities;

use App\Entities\Staff;
use App\Models\Shift as ShiftModel;
use Tests\TestCase;
use App\Entities\Shift;

class ShiftTest extends TestCase{

    public function testConstruct()
    {
        $staff = $this->getMockBuilder(Staff::class)->disableOriginalConstructor()->getMock();
        $shiftModel = $this->getMockBuilder(ShiftModel::class)->getMock();
        $shift = new Shift($staff, $shiftModel);
        $this->assertInstanceOf(Shift::class, $shift);
    }

    public function testMutators()
    {
        $staff = $this->getMockBuilder(Staff::class)->disableOriginalConstructor()->getMock();
        $shiftModel = (new ShiftModel())->setRawAttributes(['starttime' => '10', 'endtime' => '4', 'workhours' => 6]);

        $shift = new Shift($staff, $shiftModel);

        $this->assertEquals($staff,$shift->getStaff());
        $this->assertEquals(10,$shift->getStartTime());
        $this->assertEquals(4,$shift->getEndTime());
        $this->assertEquals(6,$shift->getWorkHours());
    }

}