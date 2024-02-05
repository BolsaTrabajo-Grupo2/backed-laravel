<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CycleCollection;
use App\Models\Cycle;
use Illuminate\Http\Request;

class CycleApiController extends Controller
{
    public function index(){
        $cycles = Cycle::all()->paginate(10);
        return new CycleCollection($cycles);
    }


}
