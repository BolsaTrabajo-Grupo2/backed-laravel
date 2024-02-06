<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Models\Cycle;
use App\Models\Offer;

class OfferApiController extends Controller
{
    public function index(){
        $offers = Offer::all()->paginate(10);
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
