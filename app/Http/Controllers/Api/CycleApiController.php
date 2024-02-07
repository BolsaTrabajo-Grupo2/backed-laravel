<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CycleRequest;
use App\Http\Resources\CycleCollection;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;


class CycleApiController extends Controller
{
    public function index(){
        $cycles = Cycle::paginate(10);
        return new CycleCollection($cycles);
    }
    public function show(Cycle $cycle)
    {
        return new CycleResource($cycle);
    }

    public function store(CycleRequest $cycleRequest)
    {
        $cycle = new Cycle();
        $cycle->cycle = $cycleRequest->get('cycle');
        $cycle->title = $cycleRequest->get('title');
        $cycle->id_family = $cycleRequest->get('idFamily');
        $cycle->id_responsible = $cycleRequest->get('idResponsible');
        $cycle->vliteral = $cycleRequest->get('vliteral');
        $cycle->cliteral = $cycleRequest->get('cliteral');
        $cycle->save();
        return new CycleResource($cycle);
    }

    public function update(CycleResource $cycleRequest, $id)
    {
        $cycle = Cycle::findOrFail($id);

        $cycle->cycle = $cycleRequest->get('cycle');
        $cycle->title = $cycleRequest->get('title');
        $cycle->id_family = $cycleRequest->get('idFamily');
        $cycle->id_responsible = $cycleRequest->get('idResponsible');
        $cycle->vliteral = $cycleRequest->get('vliteral');
        $cycle->cliteral = $cycleRequest->get('cliteral');
        $cycle->save();
        return new CycleResource($cycle);
    }

    public function delete($id)
    {
        $cycle = Cycle::find($id);

        if (!$cycle) {
            return response()->json(['error' => 'No se ha encontrado el ciclo'], 404);
        }

        $cycle->delete();

        return response()->json([
            'message' => 'El ciclo con id:' . $id . ' ha sido borrado con éxito',
            'data' => $id
        ], 200);
    }



}
