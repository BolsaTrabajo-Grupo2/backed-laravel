<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyRequest;
use App\Http\Resources\CycleResource;

use App\Http\Resources\FamilyCollection;
use App\Http\Resources\FamilyResource;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyApiController extends Controller
{
    public function index(){
        $families = Family::all()->paginate(10);
        return new FamilyCollection($families);
    }
    public function show(Family $family)
    {
        return new FamilyResource($family);
    }

    public function store(FamilyRequest $familyRequest)
    {
        $family = new Family();
        $family->cliteral = $familyRequest->get('cliteral');
        $family->vliteral = $familyRequest->get('vliteral');
        $family->depcurt = $familyRequest->get('depcurt');
        $family->save();

        return new FamilyResource($family);
    }

    public function update(FamilyRequest $familyRequest, $id)
    {
        $family = Family::findOrFail($id);

        $family->cliteral = $familyRequest->get('cliteral');
        $family->vliteral = $familyRequest->get('vliteral');
        $family->depcurt = $familyRequest->get('depcurt');
        $family->save();

        return new FamilyResource($family);
    }
    public function delete($id)
    {
        $family = Family::find($id);

        if (!$family) {
            return response()->json(['error' => 'No se ha encontrado la familia'], 404);
        }

        $family->delete();

        return response()->json([
            'message' => 'La familia con id:' . $id . ' ha sido borrada con éxito',
            'data' => $id
        ], 200);
    }
}
