<?php
namespace App\Http\Controllers;

use App\Http\Requests\CycleRequest;
use App\Http\Requests\OfferRequest;
use App\Models\Cycle;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    public function index()
    {
        $cycles = Cycle::paginate(10);
        return view('cycle.index', compact('cycles'));
    }
    public function show($id)
    {
        $cycle = Cycle::find($id);
        return view('cycle.show', ['cycle' => $cycle]);
    }
    public function create()
    {
        $families = Family::all();
        return view('cycle.create',compact("families"));
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

        return redirect()->route('cycle.index')->with('success', 'Ciclo añadido correctamente.');
    }

    public function edit($id)
    {
        $cycle = Cycle::find($id);
        if (!$cycle) {
            return abort(404);
        }

        return view('cycle.edit', compact('cycle'));
    }
    public function update(OfferRequest $cycleRequest, $id)
    {

        $cycle = Cycle::findOrFail($id);

        $cycle->cycle = $cycleRequest->get('cycle');
        $cycle->title = $cycleRequest->get('title');
        $cycle->id_family = $cycleRequest->get('idFamily');
        $cycle->id_responsible = $cycleRequest->get('idResponsible');
        $cycle->vliteral = $cycleRequest->get('vliteral');
        $cycle->cliteral = $cycleRequest->get('cliteral');
        $cycle->save();

        return redirect()->route('offer.show', $cycle->id)->with('success', 'Offer actualizada correctamente.');
    }
    public function destroy($id)
    {
        $cycle = Cycle::find($id);

        if (!$cycle) {
            return abort(404);
        }

        $cycle->delete();

        return redirect()->route('cycle.index')->with('success', 'Ciclo eliminado correctamente.');
    }
    public function statics(){
        $cycles = Cycle::with('assigneds')->get();
        return view('cycle.statistics', compact('cycles'));
    }
    public function modResponsible($id){
        $responsibles = User::where('rol','RESP')->get();
        $cycle = Cycle::findOrFail($id);
        return view('cycle.modResp', compact('responsibles', 'cycle'));
    }
    public function updateResponsible(Request $request, $id){
        $request->validate([
            'responsible' => 'required'
        ]);
        $cycle = Cycle::findOrFail($id);
        $cycle->id_responsible = $request->get('responsible');
        $cycle->save();
        return redirect()->route('cycles.index')->with('success', 'Responsable modificado con exito.');
    }
}
