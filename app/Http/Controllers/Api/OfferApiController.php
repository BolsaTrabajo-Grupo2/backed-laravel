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
use App\Models\Student;
use App\Models\Study;
use Illuminate\Support\Facades\Auth;

class OfferApiController extends Controller
{
    public function index(){
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
        }elseif ($user->rol == 'COMP'){
            $userCompany = Company::where('id_user',$user->id)->first();
            $offers = Offer::where('cif',$userCompany->CIF)->where('status', 1)->paginate(10);
        }elseif($user->rol == 'STU'){
            $student = Student::where('id_user', $user->id)->first();
            if ($student) {
                $studyCycles = Study::where('id_student', $student->id)->get();
                $studyCyclesIds = $studyCycles->pluck('id_cycle')->toArray();

                $assignedOffers = Assigned::where('id_cycle', $studyCyclesIds)->get();
                $assignedOfferIds = $assignedOffers->pluck('id_offer')->toArray();

                $offers = Offer::whereIn('id', $assignedOfferIds)->where('status', 1)->paginate(10);
            }

        }
        return new OfferCollection($offers);
    }
    public function show($id)
    {
        return new OfferResource(Offer::find($id));
    }

    public function store(OfferRequest $offerRequest)
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
        DB::beginTransaction();

        DB::table('assigneds')->where('id_offer', $id)->delete();
        DB::table('applies')->where('id_offer', $id)->delete();

        Offer::destroy($id);
        DB::commit();
        return response()->json([
            'message' => 'La oferta con id:' . $id . ' ha sido borrada con éxito',
            'data' => $id
        ], 200);
    }

}
