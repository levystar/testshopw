<?php

namespace App\Http\Controllers\Shift;

use App\Models\Shift;
use App\Repository\ShiftRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $repository)
    {
    	$this->shiftRepository = $repository;
    }

    public function index()
    {
    	$totalShifts  = $this->shiftRepository->getDaysShifts();

    	$staffIds = $this->shiftRepository->getStaffIds();

    	return view('shifts',['staffIds'=> $staffIds, 'totalShifts'=> $totalShifts]);
    }	

}
