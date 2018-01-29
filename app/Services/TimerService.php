<?php
/**
 * Created by PhpStorm.
 * User: dude
 * Date: 1/28/2018
 * Time: 6:11 PM
 */

namespace App\Services;
use DateTime;

class TimerService
{
    protected $shifts;

    public function workHours($shifts): int
    {
        $total =0;
        foreach ($shifts as $shift)
        {
            $total += $shift->getWorkHours();
        }
        return $total;
    }


    public function checkShifts($shifts,$alloneTimeframes = null)
    {
        if($alloneTimeframes){
            foreach($this->shifts as $otherShifts)
            {
                if ($shifts === $otherShifts) {
                    continue;
                }
                $timeframeB = $this->stringToTime($otherShifts->getStartTime(), $otherShifts->getEndTime());
                foreach ($alloneTimeframes as $alloneTimeframe) {
                    $alloneTimeframes = $this->getAloneTimeFrames($alloneTimeframe, $timeframeB);
                }
                if ($alloneTimeframes === []) {
                    return [];
                }
            }
            return $alloneTimeframes;

        } else {
            $total =0;
            $this->shifts = $shifts;
            foreach ($shifts as $shift) {
                $shiftTimeFrame = $this->stringToTime($shift->getStartTime(), $shift->getEndTime());
                $shiftTimeFrameAllone = [$shiftTimeFrame];
                $shiftTimeFrameAllone = $this->checkShifts($shift,$shiftTimeFrameAllone);
                if ($shiftTimeFrameAllone === []) {
                    continue;
                }
                $total += $this->getMinutesAlone($shiftTimeFrameAllone);
            }
            return $total;
        }

    }

    public function stringToTime($start, $end): array
    {
        $dateStart = new DateTime($start);
        $dateEnd = new DateTime($end);
        if ($dateEnd < $dateStart) {
            $dateEnd->modify('+1 day');
        }
        return [$dateStart, $dateEnd];
    }

    public function getAloneTimeFrames( $firstShift,$secondShift): array
    {

        list($firstStart, $firstEnd) = $firstShift;

        list($secondStart, $secondEnd) = $secondShift;

        if ($firstStart > $secondEnd || $firstEnd < $secondStart) {
            return [$firstShift];
        }

        if ($secondStart <= $firstStart && $secondEnd >= $firstEnd || ($firstStart == $secondStart && $firstEnd == $secondEnd)) {
            return [];
        }

        if ($secondStart > $firstStart && $secondEnd < $firstEnd) {
            return [[$firstStart, $secondStart], [$secondEnd, $firstEnd]];
        }

        if ($secondStart <= $firstStart) {
            return [[$secondEnd, $firstEnd]];
        }
        else
        {
            return [[$firstStart, $secondStart]];
        }

    }

    public function getMinutesAlone(array $timeframes): int
    {
        $total = 0;
        foreach ($timeframes as $timeframe) {
            list($start, $end) = $timeframe;
            $secondsWorkedAlone = $end->getTimestamp() - $start->getTimestamp();
            $total += $secondsWorkedAlone / 60;
        }
        return $total;
    }


}