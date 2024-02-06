<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CycleCollection;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;
use App\Models\User;

class CycleApiController extends Controller
{
    public function index(){
        $cycles = Cycle::all()->paginate(10);
        return new CycleCollection($cycles);
    }
    public function show(Cycle $cycle)
    {
        return new CycleResource($cycle);
    }


}
