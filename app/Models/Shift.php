<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
     protected $table = 'rota_slot_staff';

    public function getAll()
    {
        return $this->all();
    }


    public function getEmployeesShifts()
    {
        return $this->newQuery()
                    ->whereNotNull('staffid')
                    ->where('slottype', 'shift')
                    ->get();
    }

    public function getEmployeeIds()
    {
        return $this->newQuery()
                    ->distinct()
                    ->whereNotNull('staffid')
                    ->get(['staffid'])
                    ->pluck('staffid')
                    ->toArray();
    }
}
