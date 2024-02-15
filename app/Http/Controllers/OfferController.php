<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferBackendRequest;
use App\Http\Requests\OfferRequest;
use App\Models\Assigned;
use App\Models\Company;
use App\Models\Cycle;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $offers = null;
        if ($user->rol == 'ADM'){
            $offers = Offer::where('status', 1)->paginate(10);
        }elseif ($user->rol == 'RESP'){
            $offers = Offer::whereIn('id', function($query) use ($user) {
                $query->select('id_offer')
                    ->from(with(new Assigned)->getTable())
                    ->whereIn('id_cycle', function($query) use ($user) {
                        $query->select('id')
                            ->from(with(new Cycle)->getTable())
                            ->where('id_responsible', $user->id);
                    });
            })->where('status', 1)->paginate(10);
        }

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
    public function store(OfferBackendRequest $offerRequest)
    {
        $userAutenticate = Auth::user();
        $offer = new Offer();
        $offer->description = $offerRequest->get('description');
        $offer->duration = $offerRequest->get('duration');
        if($offerRequest->get('responsible_name')){
            $offer->responsible_name = $offerRequest->get('responsible_name');
        }else{
            $offer->responsible_name = $userAutenticate->name;
        }
        $offer->inscription_method = $offerRequest->get('inscription_method');
        $empresa = Company::where('id_user', $userAutenticate->id)->first();
        $offer->CIF = $empresa->CIF;
        $offer->status = true;
        $offer->save();
        $ciclosSelecionados = $offerRequest->get('selectedCycles');
        foreach ($ciclosSelecionados as $cycleId){
            $assigned = new Assigned();
            $assigned->id_offer = $offer->id;
            $assigned->id_cycle = $cycleId;
            $assigned->save();
        }
        return redirect()->route('offer.index')->with('success', 'Oferta añadida correctamente.');
    }

    public function edit($id)
    {
        $offer = Offer::find($id);
        if (!$offer) {
            return abort(404);
        }

        return view('offer.update', compact('offer'));
    }
    public function update(OfferRequest $offerRequest, $id)
    {

        $offer = Offer::findOrFail($id);

        $offer->description = $offerRequest->get('description');
        $offer->duration = $offerRequest->get('duration');
        $offer->responsible_name = $offerRequest->get('responsibleName');
        $offer->inscription_method = $offerRequest->get('inscriptionMethod');
        $offer->status = $offerRequest->get('status');
        $offer->save();

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
            return redirect()->route('offer.index', $id)->with('success', 'Offer eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
