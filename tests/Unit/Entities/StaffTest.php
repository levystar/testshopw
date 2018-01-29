<?php
namespace App\Tests\Unit\Entities;


use App\Entities\Staff;
use Tests\TestCase;

class StaffTest extends TestCase{
    public function testStaff()
    {

        $staff = new Staff(1);

        $this->assertEquals(1,$staff->getId());
    }

}