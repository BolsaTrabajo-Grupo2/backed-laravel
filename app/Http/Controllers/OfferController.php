<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Assigned;
use App\Models\Cycle;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index($ciclo)
    {
        $assigneds = Assigned::where('id_cycle', $ciclo)->get();
        $offers = $assigneds->map(function ($assigned) {
            return $assigned->offer;
        });
        return view('offer.index', ['offers' => $offers]);
    }
    public function show($id)
    {
        $offer = Offer::find($id);
        return view('offer.show', ['offer' => $offer]);
    }
    public function create()
    {
        $cicles = Cycle::all();
        return view('offer.create',compact("cicles"));
    }
    public function store(OfferRequest $request)
    {


        $offer = new Offer($request);
        $offer->save();

        return redirect()->route('offer.index')->with('success', 'Oferta añadida correctamente.');
    }

    public function edit($id)
    {
        $offer = Offer::find($id);
        if (!$offer) {
            return abort(404);
        }

        return view('offer.edit', compact('offer'));
    }
    public function update(OfferRequest $request, $id)
    {

        $offer = Offer::find($id);

        if (!$offer) {
            return abort(404);
        }

        $offer->update($request);

        return redirect()->route('offer.show', $offer->id)->with('success', 'Offer actualizada correctamente.');
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            DB::table('assigneds')->where('id_offer', $id)->delete();
            DB::table('applies')->where('id_offer', $id)->delete();

            Offer::destroy($id);
            DB::commit();
            return response()->json([
                'message' => 'La oferta con id:' . $id . ' y sus registros relacionados han sido eliminados con éxito',
                'data' => $id
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
