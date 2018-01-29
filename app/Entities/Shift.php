<?php

namespace App\Entities;
use App\Models\Shift as ShiftModel;

class Shift
{
    protected $startTime;

    protected $endTime;

    protected $workHours;

    protected $staff;

    public function __construct(Staff $staff, ShiftModel $shiftData)
    {
        $this->staff = $staff;
        $this->startTime = $shiftData->starttime;
        $this->endTime = $shiftData->endtime;
        $this->workHours = $shiftData->workhours;
    }

    public function getStaff(): Staff
    {
        return $this->staff;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function getWorkHours(): int
    {
        return $this->workHours;
    }
}