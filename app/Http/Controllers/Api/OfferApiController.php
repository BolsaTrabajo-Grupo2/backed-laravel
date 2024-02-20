<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Mail\NewOfferStudentMail;
use App\Mail\OfferConfirmationMail;
use App\Models\Assigned;
use App\Models\Company;
use App\Models\Cycle;
use App\Models\Offer;
use App\Models\Student;
use App\Models\Study;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
/**
 * @OA\Schema(
 *     schema="Offer",
 *     title="Offer",
 *     description="Esquema para los datos de una oferta",
 *     required={"description", "duration", "responsible_name", "inscription_method", "status", "verified", "CIF"},
 *     @OA\Property(property="description", type="string", example="Descripción de la oferta", description="Descripción de la oferta"),
 *     @OA\Property(property="duration", type="integer", example=6, description="Duración de la oferta en meses"),
 *     @OA\Property(property="responsible_name", type="string", example="John Doe", description="Nombre del responsable de la oferta"),
 *     @OA\Property(property="inscription_method", type="string", example="Online", description="Método de inscripción"),
 *     @OA\Property(property="status", type="integer", example=1, description="Estado de la oferta"),
 *     @OA\Property(property="verified", type="integer", example=1, description="Verificación de la oferta"),
 *     @OA\Property(property="CIF", type="string", example="ABC123", description="Número de identificación fiscal de la empresa"),
 * )
 */

class OfferApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/offers",
     *     summary="Obtener todas las ofertas",
     *     description="Obtiene todas las ofertas disponibles según el rol del usuario autenticado",
     *     operationId="getAllOffers",
     *     tags={"Offers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="total_pages", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total_records", type="integer", example=50),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Offer")
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(property="prev", type="string", example="http://example.com/api/offers?page=1"),
     *                 @OA\Property(property="next", type="string", example="http://example.com/api/offers?page=3")
     *             ),
     *             @OA\Property(property="status", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function index(){
        $user = Auth::user();
        $offers = null;
        if ($user->rol == 'ADM'){
            $offers = Offer::where('status', 1)->where('verified',1)->paginate(10);
        }elseif ($user->rol == 'RESP'){
            $offers = Offer::whereIn('id', function($query) use ($user) {
                $query->select('id_offer')
                    ->from(with(new Assigned)->getTable())
                    ->whereIn('id_cycle', function($query) use ($user) {
                        $query->select('id')
                            ->from(with(new Cycle)->getTable())
                            ->where('id_responsible', $user->id);
                    });
            })->where('status', 1)->where('verified',1)->paginate(10);
        }elseif ($user->rol == 'COMP'){
            $userCompany = Company::where('id_user',$user->id)->first();
            $offers = Offer::where('cif',$userCompany->CIF)->where('status', 1)->where('verified',1)->paginate(10);
        }elseif($user->rol == 'STU'){
            $student = Student::where('id_user', $user->id)->first();
            if ($student) {
                $studyCycles = Study::where('id_student', $student->id)->get();
                $studyCyclesIds = $studyCycles->pluck('id_cycle')->toArray();
                $assignedOfferIds = [];
                foreach ($studyCyclesIds as $cycleId){
                    $assignedOffers = Assigned::where('id_cycle', $cycleId)->pluck('id_offer')->toArray();
                    $assignedOfferIds = array_merge($assignedOfferIds, $assignedOffers);
                }
                $offers = Offer::whereIn('id', $assignedOfferIds)->where('status', 1)->where('verified', 1)->paginate(10);
            }
        }
        return new OfferCollection($offers);
    }
    /**
     * @OA\Get(
     *     path="/api/offers/{id}",
     *     summary="Obtener detalles de una oferta",
     *     description="Obtiene los detalles de una oferta según su ID",
     *     operationId="getOfferById",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la oferta",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Offer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="La oferta no se encontró"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function show($id)
    {
        return new OfferResource(Offer::find($id));
    }
    /**
     * @OA\Post(
     *     path="/api/offers",
     *     summary="Crear una nueva oferta",
     *     description="Crea una nueva oferta y la guarda en la base de datos",
     *     operationId="createOffer",
     *     tags={"Offers"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la oferta a crear",
     *         @OA\JsonContent(
     *             required={"description", "duration", "inscription_method", "selectedCycles"},
     *             @OA\Property(property="description", type="string", example="Descripción de la oferta"),
     *             @OA\Property(property="duration", type="string", example="6 meses", description="Duración de la oferta"),
     *             @OA\Property(property="responsibleName", type="string", example="John Doe", description="Nombre del responsable de la oferta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Oferta creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Offer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unprocessable Entity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */



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
        $offer->verified = false;
        $offer->save();
        $ciclosSelecionados = $offerRequest->get('selectedCycles');
        foreach ($ciclosSelecionados as $cycleId){
            $assigned = new Assigned();
            $assigned->id_offer = $offer->id;
            $assigned->id_cycle = $cycleId;
            $cycle = Cycle::findOrFail($cycleId);
            $user = User::where('id',$cycle->id_responsible)->first();
            Mail::to($user->email)->send(new OfferConfirmationMail($offer,$user,$cycle));
            $assigned->save();
        }
        return new OfferResource($offer);
    }
    /**
     * @OA\Put(
     *     path="/api/offers/{id}",
     *     summary="Actualizar una oferta existente",
     *     description="Actualiza los datos de una oferta existente en la base de datos",
     *     operationId="updateOffer",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la oferta a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos actualizados de la oferta",
     *         @OA\JsonContent(
     *             required={"description", "duration"},
     *             @OA\Property(property="description", type="string", example="Nueva descripción de la oferta", maxLength=200),
     *             @OA\Property(property="duration", type="string", example="24 meses", description="Nueva duración de la oferta (máx. 50 caracteres)"),
     *             @OA\Property(property="responsibleName", type="string", example="Nuevo nombre del responsable de la oferta (opcional)", maxLength=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Offer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oferta no encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unprocessable Entity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

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
    /**
     * @OA\Put(
     *     path="/api/offersDeactivate/{id}",
     *     summary="Desactivar una oferta",
     *     description="Desactiva una oferta existente en la base de datos cambiando su estado a inactivo",
     *     operationId="deactivateOffer",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la oferta a desactivar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta desactivada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="La oferta con ID: {id} ha sido desactivada con éxito"),
     *             @OA\Property(property="data", ref="#/components/schemas/Offer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oferta no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function deactivate($id)
    {
        $offer = Offer::findOrFail($id);

        $offer->status = false;
        $offer->save();

        return response()->json([
            'message' => 'La oferta con id:' . $id . ' ha sido desactivada con éxito',
            'data' => $offer
        ], 200);
    }
    /**
     * @OA\Delete(
     *     path="/api/offersDelete/{id}",
     *     summary="Borrar oferta",
     *     description="Marca una oferta como 'borrada' cambiando su estado a inactivo",
     *     operationId="deleteOffer",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la oferta a marcar como 'borrada'",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oferta marcada como 'borrada' exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="La oferta con ID: {id} ha sido marcada como 'borrada' con éxito"),
     *             @OA\Property(property="data", ref="#/components/schemas/Offer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oferta no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function delete($id)
    {
        $offer = Offer::findOrFail($id);

        $offer->status = false;
        $offer->save();


        return response()->json([
            'message' => 'La oferta con id:' . $id . ' ha sido marcada como "borrada" con éxito',
            'data' => $offer
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/offerByCP/{cp}",
     *     summary="Obtener ofertas por código postal",
     *     description="Obtiene una lista paginada de ofertas filtradas por código postal de la empresa asociada",
     *     operationId="getOfferByCP",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="cp",
     *         in="path",
     *         description="Código postal para filtrar las ofertas",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="cp_format"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="current_page", type="integer", example=1),
     *              @OA\Property(property="total_pages", type="integer", example=5),
     *              @OA\Property(property="per_page", type="integer", example=10),
     *              @OA\Property(property="total_records", type="integer", example=50),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Offer")
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  type="object",
     *                  @OA\Property(property="prev", type="string", example="http://example.com/api/offers?page=1"),
     *                  @OA\Property(property="next", type="string", example="http://example.com/api/offers?page=3")
     *              ),
     *              @OA\Property(property="status", type="string", example="success")
     *          )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron ofertas para el código postal proporcionado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public  function getOfferByCP($cp){
        $offersPaginated = $this->index();

        $filteredOffersPaginated = $offersPaginated->filter(function ($item) use ($cp) {
            return $item->company->CP == $cp;
        });
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredOffersPaginated->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), 10),
            $filteredOffersPaginated->count(),
            10,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return new OfferCollection($paginator);
    }

    /**
     * @OA\Post(
     *     path="/api/verificateOffer/{idOffer}",
     *     summary="Verificar oferta",
     *     description="Verifica una oferta específica y notifica a los estudiantes asignados a los ciclos asociados",
     *     operationId="verifyOffer",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="idOffer",
     *         in="path",
     *         description="ID de la oferta a verificar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\MediaType(
     *             mediaType="text/html",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oferta no encontrada"
     *     )
     * )
     */

    public function verificate($idOffer){
        $offer = Offer::findOrFail($idOffer);
        $offer->verified = true;
        $offer->save();
        $cycleOffers = Assigned::where('id_offer',$offer->id)->get();
        foreach ($cycleOffers as $cycle) {
            $studentsCycle = Study::where('id_cycle',$cycle->id_cycle)->get();
            $c = Cycle::findOrFail($cycle->id_cycle);
            foreach ($studentsCycle as $student){
                $s = Student::findOrFail($student->id_student);
                $u = User::findOrFail($s->id_user);
                Mail::to($u->email)->send(new NewOfferStudentMail($u,$offer,$c));
            }
        }
        return view('emails.succes_verified_email');
    }
    /**
     * @OA\Put(
     *     path="/api/spread/{idOffer}",
     *     summary="Extender oferta",
     *     description="Extiende la fecha de creación de una oferta específica.",
     *     operationId="spreadOffer",
     *     tags={"Offers"},
     *     @OA\Parameter(
     *         name="idOffer",
     *         in="path",
     *         description="ID de la oferta a extender",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="La fecha de creación de la oferta se ha extendido con éxito"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oferta no encontrada"
     *     )
     * )
     */

    public function spread($idOffer){
        $offer = Offer::findOrFail($idOffer);
        $offer->created_at = Carbon::now();
        $offer->save();
    }

}
