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
        $cycleOffer = Assigned::where('id_offer',$offer->id)->get();
        return view('offer.show', ['offer' => $offer,'cycles' => $cycleOffer]);
    }
    public function create()
    {
        $cicles = Cycle::all();
        $companyes = Company::all();
        return view('offer.create',['cicles' => $cicles, 'companies' => $companyes]);
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
        if($offerRequest->get('inscription_method')){
            $offer->inscription_method = $offerRequest->get('inscription_method');
        }else{
            $offer->inscription_method = false;
        }
        $empresa = Company::where('CIF', $offerRequest->get('CIF'))->first();
        if($empresa){
            $offer->CIF = $empresa->CIF;
        }
        $offer->status = true;
        $offer->verified = true;
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
        $cycles = Cycle::all();
        $companies = Company::all();
        $cyclesOffer = Assigned::where('id_offer',$offer->id)->get();

        return view('offer.update', ['offer' => $offer,'cyclesOffer'=>$cyclesOffer,'cycles'=>$cycles,'companies' => $companies]);
    }
    public function update(OfferRequest $offerRequest, $id)
    {
        $offer = Offer::findOrFail($id);

        $offer->description = $offerRequest->get('description');
        $offer->duration = $offerRequest->get('duration');
        $offer->responsible_name = $offerRequest->get('responsible_name');
        $offer->inscription_method = $offerRequest->get('inscription_method');
        $selectedCycles = $offerRequest->get('selectedCycles');
        $cyclosOferta = Assigned::where('id_offer',$offer->id)->get();
        foreach ($cyclosOferta as $cOffert){
            $cOffert->delete();
        }
        foreach ($selectedCycles as $cycle) {
            $assigned = new Assigned();
            $assigned->id_offer = $offer->id;
            $assigned->id_cycle = $cycle;
            $assigned->save();
        }
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
