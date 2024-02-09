<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Models\Assigned;
use App\Models\Company;
use App\Models\Cycle;
use App\Models\Offer;
use App\Models\Study;
use http\Client\Curl\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;


class OfferApiController extends Controller
{
    public function index(){
        $user = Auth::user();
        $offers = null;
        if ($user->rol == 'ADM'){
            $offers = Offer::paginate(10);
        }elseif ($user->rol == 'RESP'){
            $arrayCiclos = [];
            $ciclosDelRespondable = Cycle::where('id_responsible',$user->id)->get();
            foreach ($ciclosDelRespondable as $cycle){
                $ofertasDelCiclo = Assigned::where('id_cycle',$cycle->id)->get();
                foreach ($ofertasDelCiclo as $off){
                    $o = Offer::findOrFail($off->id_offer);
                    $arrayCiclos[] = $o;
                }
            }
            $colecciónCiclos = collect($arrayCiclos);
        }elseif ($user->rol == 'COMP'){
            $userCompany = Company::where('id_user',$user->id)->first();
            $offers = Offer::where('cif',$userCompany->CIF)->paginate(10);
        }elseif($user->rol == 'STU'){
            $cycles = Study::with('id_user',$user->id)->get();
            $offerResponsible = [];
            foreach ($cycles as $cycle){
                $offersCycle = Assigned::where('id_cycle',$cycle->id)->get();
                foreach ($offersCycle as $offer){
                    $offerResponsible[] = $offer;
                }
            }
            $offers = collect($offerResponsible)->paginate(10);
        }

        return new OfferCollection($offers);
    }
    public function show(Offer $offer)
    {
        return new OfferResource($offer);
    }

    public function store(OfferRequest $offerRequest)
    {
        $offer = new Offer();
        $offer->description = $offerRequest->get('description');
        $offer->duration = $offerRequest->get('duration');
        $offer->responsibleName = $offerRequest->get('responsibleName');
        $offer->inscriptionMethod = $offerRequest->get('inscriptionMethod');
        $offer->status = $offerRequest->get('status');
        $offer->save();

        return new OfferResource($offer);
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

        return new OfferResource($offer);
    }
    public function delete($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return response()->json(['error' => 'No se ha encontrado la oferta'], 404);
        }

        $offer->delete();

        return response()->json([
            'message' => 'La oferta con id:' . $id . ' ha sido borrada con éxito',
            'data' => $id
        ], 200);
    }

}
