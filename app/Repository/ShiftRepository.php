<?php
/**
 * Created by PhpStorm.
 * User: dude
 * Date: 1/28/2018
 * Time: 4:45 PM
 */
namespace App\Repository;

use App\Entities\Day;
use App\Models\Shift;
use App\Services\TimerService;

class ShiftRepository
{
    protected $shiftModel;

    protected $timerService;

    public function __construct
    (
        Shift $shiftModel,
        TimerService $timerService
    )
    {
        $this->shiftModel = $shiftModel;
        $this->timerService = $timerService;
    }

    public function getDaysShifts()
    {
        $shifts = $this->shiftModel->getEmployeesShifts();

        return $this->createDays($shifts);
    }

    public function getStaffIds()
    {
      return $resultCollection = $this->shiftModel->getEmployeeIds();
    }

    public function createDays($shifts)
    {
        $shiftsByDay = $this->sort($shifts);
        $workDays = [];
        foreach ($shiftsByDay as $dayNumber => $shiftsOfTheDay) {
            foreach ($shiftsOfTheDay as $shiftData) {
                $staff = new \App\Entities\Staff($shiftData->staffid);
                $shift = new \App\Entities\Shift($staff, $shiftData);
                $day = $workDays[$dayNumber] ?? new Day($shiftData->daynumber,$this->timerService);
                $day->addShift($shift);
                $workDays[$dayNumber] = $day;
            }
        }
        return $workDays;
    }

    public function sort($shifts): array
    {
        $result = [];
        foreach ($shifts as $shift) {
            $day = $shift->daynumber;
            $result[$day][] = $shift;
        }
        return $result;
    }
}