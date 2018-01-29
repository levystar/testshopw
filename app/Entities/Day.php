<?php
/**
 * Created by PhpStorm.
 * User: dude
 * Date: 1/28/2018
 * Time: 4:49 PM
 */

namespace App\Entities;
use App\Services\TimerService;
use Illuminate\Support\Collection;

class Day
{
    protected $day = 0;

    protected $shifts;

    protected $timerService;

    protected $totalHours;

    protected $minutesAlone;

    public function __construct($day, TimerService $timerService) {
        $this->day = $day;
        $this->shifts = new Collection([]);
        $this->timerService = $timerService;
    }

    public function addShift(Shift $shift): Day
    {
        $this->shifts->push($shift);
        return $this;
    }

    public function getShiftForEmployee(int $employeeId): ?Shift
    {
        foreach ($this->getShifts() as $shift) {
            if ($shift->getStaff()->getId() === $employeeId) {
                return $shift;
            }
        }
        return null;
    }

    public function getTotalHours(): ?int
    {
        if (!is_null($this->totalHours)) {
            return $this->totalHours;
        }
        $this->totalHours = $this->timerService->workHours($this->shifts);
        return $this->totalHours;
    }

    public function getMinutesWorkedAlone(): ?int
    {
        if (!is_null($this->minutesAlone)) {
            return $this->minutesAlone;
        }
       $this->minutesAlone = $this->timerService->checkShifts($this->shifts);

        return $this->minutesAlone;
    }

    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    public function setShifts(Collection $shifts)
    {
        $this->shifts = $shifts;
    }

    public function setDay(int $day)   
    {
        $this->day = $day;
    }

    public function getDay(): int
    {
        return $this->day;
    }

}