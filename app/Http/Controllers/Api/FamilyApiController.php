<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyRequest;
use App\Http\Resources\CycleResource;

use App\Http\Resources\FamilyCollection;
use App\Http\Resources\FamilyResource;
use App\Models\Family;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Family",
 *     title="Family",
 *     description="Esquema para los datos de una familia",
 *     @OA\Property(property="id", type="integer", example=1, description="ID de la familia"),
 *     @OA\Property(property="cliteral", type="string", example="cliteral_value", description="Valor cliteral"),
 *     @OA\Property(property="vliteral", type="string", example="vliteral_value", description="Valor vliteral"),
 *     @OA\Property(property="depcurt", type="string", example="depcurt_value", description="Valor depcurt")
 * )
 * @OA\Get(
 *     path="/api/families",
 *     summary="Obtener lista de familias",
 *     description="Devuelve una lista paginada de familias",
 *     operationId="getFamilyIndex",
 *     tags={"Families"},
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="current_page", type="integer"),
 *             @OA\Property(property="total_pages", type="integer"),
 *             @OA\Property(property="per_page", type="integer"),
 *             @OA\Property(property="total_records", type="integer"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(ref="#/components/schemas/Family")
 *             ),
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="links", type="object",
 *                 @OA\Property(property="prev", type="string", nullable=true),
 *                 @OA\Property(property="next", type="string", nullable=true)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No se encontraron familias"
 *     ),
 *     @OA\Response(
 *           response=401,
 *           description="No autorizado"
 *       )
 * )
 * @OA\Get(
 *     path="/api/families/{family}",
 *     summary="Obtener detalles de una familia",
 *     description="Devuelve los detalles de una familia específica",
 *     operationId="getFamily",
 *     tags={"Families"},
 *     @OA\Parameter(
 *         name="family",
 *         in="path",
 *         description="ID de la familia",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(ref="#/components/schemas/Family")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No se encontró la familia"
 *     ),
 *     @OA\Response(
 *           response=401,
 *           description="No autorizado"
 *       )
 * )
 * @OA\Post(
 *     path="/api/families",
 *     summary="Crear una nueva familia",
 *     description="Crea una nueva familia con los datos proporcionados",
 *     operationId="createFamily",
 *     tags={"Families"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la nueva familia",
 *         @OA\JsonContent(
 *             required={"cliteral", "vliteral", "depcurt"},
 *             @OA\Property(property="cliteral", type="string", example="Valor cliteral"),
 *             @OA\Property(property="vliteral", type="string", example="Valor vliteral"),
 *             @OA\Property(property="depcurt", type="string", example="Valor depcurt")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Familia creada exitosamente",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Family"
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación"
 *     ),
 *     @OA\Response(
 *            response=401,
 *            description="No autorizado"
 *     )
 * )
 * @OA\Put(
 *     path="/api/families/{id}",
 *     summary="Actualizar detalles de una familia",
 *     description="Actualiza los detalles de una familia existente",
 *     operationId="updateFamily",
 *     tags={"Families"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la familia a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos actualizados de la familia",
 *         @OA\JsonContent(
 *             required={"cliteral", "vliteral", "depcurt"},
 *             @OA\Property(property="cliteral", type="string", example="Nuevo valor cliteral"),
 *             @OA\Property(property="vliteral", type="string", example="Nuevo valor vliteral"),
 *             @OA\Property(property="depcurt", type="string", example="Nuevo valor depcurt")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Familia actualizada exitosamente",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/Family"
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No se encontró la familia"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación"
 *     ),
 *     @OA\Response(
 *             response=401,
 *             description="No autorizado"
 *      )
 * )
 * @OA\Delete(
 *     path="/api/families/{id}",
 *     summary="Eliminar una familia",
 *     description="Elimina una familia por su ID",
 *     operationId="deleteFamily",
 *     tags={"Families"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la familia a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Familia eliminada exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La familia con id: 1 ha sido borrada con éxito"),
 *             @OA\Property(property="data", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No se encontró la familia"
 *     ),
 *     @OA\Response(
 *             response=401,
 *             description="No autorizado"
 *      )
 * )
 */


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
