<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CycleRequest;
use App\Http\Resources\CycleCollection;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;

/**
 * @OA\Schema(
 *     schema="Cycle",
 *     title="Cycle",
 *     description="Esquema para los datos de un ciclo",
 *     required={"cycle", "title", "id_family", "id_responsible", "vliteral", "cliteral"},
 *     @OA\Property(property="cycle", type="string", example="cycle_value", description="Descripción del ciclo"),
 *     @OA\Property(property="title", type="string", example="title_value", description="Título del ciclo"),
 *     @OA\Property(property="id_family", type="integer", example=1, description="ID de la familia del ciclo"),
 *     @OA\Property(property="id_responsible", type="integer", example=1, description="ID del responsable del ciclo"),
 *     @OA\Property(property="vliteral", type="string", example="vliteral_value", description="Valor literal del ciclo"),
 *     @OA\Property(property="cliteral", type="string", example="cliteral_value", description="Código literal del ciclo")
 * )
 * @OA\Get(
 *     path="/api/cyclesPaginate",
 *     summary="Obtener lista de ciclos",
 *     description="Devuelve una lista paginada de ciclos",
 *     operationId="getCyclesIndex",
 *     tags={"Cycles"},
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
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="nombre", type="string", example="Nombre del ciclo"),
 *                     @OA\Property(property="idFamilia", type="integer", example=1),
 *                     @OA\Property(property="idResponsable", type="integer", example=1)
 *                 )
 *             ),
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="links",
 *                 type="object",
 *                 @OA\Property(property="prev", type="string", example="url_pagina_anterior"),
 *                 @OA\Property(property="next", type="string", example="url_pagina_siguiente")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="No autorizado"
 *      )
 * )
 * @OA\Get(
 *     path="/api/cycles/{id}",
 *     summary="Obtener detalles de un ciclo",
 *     description="Devuelve los detalles de un ciclo específico",
 *     operationId="getCycle",
 *     tags={"Cycles"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del ciclo a obtener",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="nombre", type="string", example="Nombre del ciclo"),
 *             @OA\Property(property="idFamilia", type="integer", example=1),
 *             @OA\Property(property="idResponsable", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Ciclo no encontrado"
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="No autorizado"
 *      )
 * )
 * @OA\Post(
 *     path="/api/cycles",
 *     summary="Crear un nuevo ciclo",
 *     description="Crea un nuevo ciclo con la información proporcionada",
 *     operationId="createCycle",
 *     tags={"Cycles"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del nuevo ciclo",
 *         @OA\JsonContent(
 *             required={"cycle", "title", "idFamily", "idResponsible", "vliteral", "cliteral"},
 *             @OA\Property(property="cycle", type="string", example="2023-2024"),
 *             @OA\Property(property="title", type="string", example="Título del ciclo"),
 *             @OA\Property(property="idFamily", type="integer", example=1),
 *             @OA\Property(property="idResponsible", type="integer", example=1),
 *             @OA\Property(property="vliteral", type="string", example="Valor literal del ciclo"),
 *             @OA\Property(property="cliteral", type="string", example="Color literal del ciclo")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Ciclo creado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="cycle", type="string", example="2023-2024"),
 *             @OA\Property(property="title", type="string", example="Título del ciclo"),
 *             @OA\Property(property="idFamily", type="integer", example=1),
 *             @OA\Property(property="idResponsible", type="integer", example=1),
 *             @OA\Property(property="vliteral", type="string", example="Valor literal del ciclo"),
 *             @OA\Property(property="cliteral", type="string", example="Color literal del ciclo")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación"
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="No autorizado"
 *      )
 * )
 * @OA\Put(
 *     path="/api/cycles/{id}",
 *     summary="Actualizar un ciclo existente",
 *     description="Actualiza un ciclo existente con la información proporcionada",
 *     operationId="updateCycle",
 *     tags={"Cycles"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del ciclo a actualizar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos actualizados del ciclo",
 *         @OA\JsonContent(
 *             required={"cycle", "title", "idFamily", "idResponsible", "vliteral", "cliteral"},
 *             @OA\Property(property="cycle", type="string", example="2023-2024"),
 *             @OA\Property(property="title", type="string", example="Título actualizado del ciclo"),
 *             @OA\Property(property="idFamily", type="integer", example=1),
 *             @OA\Property(property="idResponsible", type="integer", example=1),
 *             @OA\Property(property="vliteral", type="string", example="Valor literal actualizado del ciclo"),
 *             @OA\Property(property="cliteral", type="string", example="Color literal actualizado del ciclo")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ciclo actualizado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="cycle", type="string", example="2023-2024"),
 *             @OA\Property(property="title", type="string", example="Título actualizado del ciclo"),
 *             @OA\Property(property="idFamily", type="integer", example=1),
 *             @OA\Property(property="idResponsible", type="integer", example=1),
 *             @OA\Property(property="vliteral", type="string", example="Valor literal actualizado del ciclo"),
 *             @OA\Property(property="cliteral", type="string", example="Color literal actualizado del ciclo")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Ciclo no encontrado"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error de validación"
 *     ),
 *     @OA\Response(
 *           response=401,
 *           description="No autorizado"
 *       )
 * )
 * @OA\Delete(
 *     path="/api/cycles/{id}",
 *     summary="Eliminar un ciclo existente",
 *     description="Elimina un ciclo existente según su ID",
 *     operationId="deleteCycle",
 *     tags={"Cycles"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del ciclo a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ciclo eliminado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="El ciclo con id: 1 ha sido borrado con éxito"),
 *             @OA\Property(property="data", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Ciclo no encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="No se ha encontrado el ciclo")
 *         )
 *     ),
 *     @OA\Response(
 *           response=401,
 *           description="No autorizado"
 *       )
 * )
 * @OA\Get(
 *     path="/api/cycles",
 *     summary="Obtener todos los ciclos",
 *     description="Obtiene todos los ciclos disponibles",
 *     operationId="getAllCyclesSinCollction",
 *     tags={"Cycles"},
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Cycle")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     )
 * )
 */



class CycleApiController extends Controller
{
    public function index(){
        $cycles = Cycle::paginate(10);
        return new CycleCollection($cycles);
    }
    public function show(Cycle $cycle)
    {
        return new CycleResource($cycle);
    }
    public function getAll(){
        return Cycle::all();
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
        return new CycleResource($cycle);
    }

    public function update(CycleResource $cycleRequest, $id)
    {
        $cycle = Cycle::findOrFail($id);

        $cycle->cycle = $cycleRequest->get('cycle');
        $cycle->title = $cycleRequest->get('title');
        $cycle->id_family = $cycleRequest->get('idFamily');
        $cycle->id_responsible = $cycleRequest->get('idResponsible');
        $cycle->vliteral = $cycleRequest->get('vliteral');
        $cycle->cliteral = $cycleRequest->get('cliteral');
        $cycle->save();
        return new CycleResource($cycle);
    }

    public function delete($id)
    {
        $cycle = Cycle::find($id);

        if (!$cycle) {
            return response()->json(['error' => 'No se ha encontrado el ciclo'], 404);
        }

        $cycle->delete();

        return response()->json([
            'message' => 'El ciclo con id:' . $id . ' ha sido borrado con éxito',
            'data' => $id
        ], 200);
    }



}
