<?php
namespace App\Http\Controllers;

use App\Models\Cycle;

class CycleController extends Controller
{
    public function index()
    {
        $cycles = Cycle::with('assigneds')->get();
        return view('cycle.index', compact('cycles'));
    }
}
