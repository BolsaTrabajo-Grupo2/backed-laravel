<?php
namespace App\Http\Controllers;

use App\Models\Cycle;

class CycleController extends Controller
{
    public function index()
    {
        $cycles = Cycle::withCount('assigneds')->paginate(10);
        return view('cycle.index', compact('cycles'));
    }
}
