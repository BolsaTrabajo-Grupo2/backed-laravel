<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Schema(
 *      schema="CompanyUpdateRequest",
 *      title="Company Update Request",
 *      description="Esquema para los datos requeridos al actualizar una empresa",
 *      @OA\Property(property="name", type="string", maxLength=250, example="Nombre de la empresa"),
 *      @OA\Property(property="surname", type="string", maxLength=250, example="Apellido de la empresa"),
 *      @OA\Property(property="CIF", type="string", maxLength=9, example="ABC123456"),
 *      @OA\Property(property="company_name", type="string", maxLength=100, example="Nombre completo de la empresa"),
 *      @OA\Property(property="address", type="string", maxLength=250, example="Dirección de la empresa"),
 *      @OA\Property(property="CP", type="string", maxLength=5, example="12345"),
 *      @OA\Property(property="phone", type="string", maxLength=9, example="123456789"),
 *      @OA\Property(property="web", type="string", format="url", example="http://www.empresa.com"),
 *      required={"name", "surname", "CIF", "company_name", "address", "CP", "phone"}
 *  )
 * /
 * @OA\Schema(
 *      schema="CompanyRequest",
 *      title="Company Request",
 *      description="Esquema para los datos requeridos al crear una nueva empresa",
 *      @OA\Property(property="name", type="string", maxLength=250, example="Nombre de la empresa"),
 *      @OA\Property(property="surname", type="string", maxLength=250, example="Apellido de la empresa"),
 *      @OA\Property(property="CIF", type="string", maxLength=9, example="ABC123456", pattern="^[A-Z]\d{8}$"),
 *      @OA\Property(property="email", type="string", format="email", example="empresa@example.com"),
 *      @OA\Property(property="company_name", type="string", maxLength=100, example="Nombre completo de la empresa"),
 *      @OA\Property(property="address", type="string", maxLength=250, example="Dirección de la empresa"),
 *      @OA\Property(property="CP", type="string", maxLength=5, example="12345"),
 *      @OA\Property(property="phone", type="string", maxLength=9, example="123456789"),
 *      @OA\Property(property="web", type="string", format="url", example="http://www.empresa.com"),
 *      @OA\Property(property="password", type="string", minLength=8, pattern="^(?=.*[A-Z])(?=.*\d).{8,}$", example="Password123"),
 *      @OA\Property(property="confirmPassword", type="string", example="Password123"),
 *      @OA\Property(property="rol", type="string", example="admin"),
 *      required={"name", "surname", "CIF", "email", "company_name", "address", "CP", "phone", "rol"}
 *  )
 * /
 * @OA\Schema(
 *      schema="Company",
 *      title="Company",
 *      description="Esquema para los datos de una empresa",
 *      @OA\Property(property="idUsuario", type="integer", example=1, description="ID del usuario propietario de la empresa"),
 *      @OA\Property(property="CIF", type="string", example="ABC123", description="Número de identificación fiscal de la empresa"),
 *      @OA\Property(property="companyName", type="string", example="Empresa XYZ", description="Nombre de la empresa"),
 *      @OA\Property(property="direccion", type="string", example="Calle Principal 123", description="Dirección de la empresa"),
 *      @OA\Property(property="CP", type="string", example="12345", description="Código Postal de la empresa"),
 *      @OA\Property(property="telefono", type="string", example="123-456-7890", description="Teléfono de la empresa"),
 *      @OA\Property(property="web", type="string", example="https://www.empresa.com", description="Sitio web de la empresa")
 *  )
 * /
 * @OA\Schema(
 *     schema="CompanyPagination",
 *     title="Company Pagination",
 *     description="Esquema para la colección paginada de empresas",
 *     @OA\Property(property="current_page", type="integer", example=1, description="Número de la página actual"),
 *     @OA\Property(property="total_pages", type="integer", example=5, description="Número total de páginas"),
 *     @OA\Property(property="per_page", type="integer", example=10, description="Número de elementos por página"),
 *     @OA\Property(property="total_records", type="integer", example=47, description="Número total de registros"),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Company"), description="Datos de las empresas"),
 *     @OA\Property(property="status", type="string", example="success", description="Estado de la respuesta"),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(property="prev", type="string", example="http://example.com/api/company?page=1", description="Enlace a la página anterior"),
 *         @OA\Property(property="next", type="string", example="http://example.com/api/company?page=3", description="Enlace a la página siguiente")
 *     )
 * )
 * @OA\Get(
 *     path="/api/company",
 *     summary="Obtener lista de empresas",
 *     description="Devuelve una lista de empresas paginada",
 *     operationId="getCompanyIndex",
 *     tags={"Company"},
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="pagination", ref="#/components/schemas/CompanyPagination")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado"
 *     )
 * )
 * @OA\Get(
 *     path="/api/company/{id}",
 *     summary="Obtener detalles de una empresa",
 *     description="Devuelve los detalles de una empresa específica",
 *     operationId="getCompany",
 *     tags={"Company"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la empresa",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             ref="#/components/schemas/Company"
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Empresa no encontrada"
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="No autorizado"
 *      )
 * )
 * @OA\Post(
 *     path="/api/company",
 *     summary="Crear una nueva empresa",
 *     description="Crea una nueva empresa con los datos proporcionados",
 *     operationId="createCompany",
 *     tags={"Company"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la empresa a crear",
 *         @OA\JsonContent(ref="#/components/schemas/CompanyRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Empresa creada exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Datos de entrada no válidos",
 *     )
 * )
 * @OA\Put(
 *     path="/api/company/{id}",
 *     summary="Actualizar una empresa",
 *     description="Actualiza una empresa existente con los datos proporcionados",
 *     operationId="updateCompany",
 *     tags={"Company"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la empresa a actualizar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la empresa a actualizar",
 *         @OA\JsonContent(ref="#/components/schemas/CompanyUpdateRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empresa actualizada exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             ref="#/components/schemas/Company"
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Empresa no encontrada"
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="No autorizado"
 *      )
 * )
 * @OA\Delete(
 *     path="/api/company/{cif}",
 *     summary="Eliminar una empresa",
 *     description="Elimina una empresa por su CIF",
 *     operationId="deleteCompany",
 *     tags={"Company"},
 *     @OA\Parameter(
 *         name="cif",
 *         in="path",
 *         required=true,
 *         description="CIF de la empresa a eliminar",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empresa eliminada exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="La empresa ha sido borrada con éxito"),
 *             @OA\Property(property="data", type="integer", example=123)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Empresa no encontrada"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor"
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="No autorizado"
 *      )
 * )
 */



class CompanyApiController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);
        return new CompanyCollection($companies);
    }

    public function show(Company $company)
    {
        return new CompanyResource($company);
    }
    public function store(CompanyRequest $request)
    {
        $userResponse = UserApiController::register($request);
        $user = $userResponse->getOriginalContent()['user'];
        $token = $userResponse->getOriginalContent()['token'];
        $company = new Company();
        $company->CIF = $request->get('CIF');
        $company->id_user = $user->id;
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->company_name = $request->get('company_name');
        $company->CP = $request->get('CP');
        $company->created_at = Carbon::now();
        $company->updated_at = Carbon::now();
        $company->save();
        $user->notify(new NewStudentOrCompanyNotification($user));
        return response()->json(['token' => $token], 201);
    }

    public function update(CompanyUpdateRequest $request, $id)
    {
        $userApi = new UserApiController();
        $companyResponse = $userApi->update($request,$id);
        $company = Company::where('id_user',$id)->firstOrFail();
        $company->CIF = $request->get('CIF');
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->company_name = $request->get('company_name');
        $company->CP = $request->get('CP');
        $company->updated_at = Carbon::now();
        $company->save();
        return new CompanyResource($company);
    }

    public function delete($cif)
    {
        $company = Company::where('CIF',$cif)->first();
        if (!$company) {
            return abort(404);
        }
        $userId = $company->id_user;
        DB::beginTransaction();
        try {
            $cifToDelete = $company->CIF;
            DB::table('offers')
                ->where('CIF', $cifToDelete)
                ->update(['CIF' => null]);
            $company->delete();
            DB::table('users')->where('id', $userId)->delete();
            DB::commit();
            return response()->json([
                'message' => 'La empresa con id:' . $userId . ' ha sido borrada con éxito',
                'data' => $userId
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'La empresa con id:' . $userId . ' no se ha podido borrar',
                'data' => $userId
            ], (500));
        }

    }
    /**
     * @OA\Get(
     *     path="/api/company/{idUser}",
     *     summary="Obtener empresa por ID de usuario",
     *     description="Obtiene los detalles de una empresa por el ID de usuario",
     *     operationId="getCompanyByIdUser",
     *     tags={"Company"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1, description="ID del usuario"),
     *             @OA\Property(property="name", type="string", example="John Doe", description="Nombre del usuario"),
     *             @OA\Property(property="email", type="string", example="john@example.com", description="Correo electrónico del usuario"),
     *             @OA\Property(property="accept", type="boolean", example=true, description="Acepta"),
     *             @OA\Property(property="rol", type="string", example="admin", description="Rol del usuario"),
     *             @OA\Property(property="CIF", type="string", example="ABC123", description="Número de identificación fiscal de la empresa"),
     *             @OA\Property(property="company_name", type="string", example="Empresa XYZ", description="Nombre de la empresa"),
     *             @OA\Property(property="address", type="string", example="Calle Principal 123", description="Dirección de la empresa"),
     *             @OA\Property(property="CP", type="string", example="12345", description="Código Postal de la empresa"),
     *             @OA\Property(property="phone", type="string", example="123-456-7890", description="Teléfono de la empresa"),
     *             @OA\Property(property="web", type="string", example="https://www.empresa.com", description="Sitio web de la empresa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */

    public function getCompany($id) {
        $user = User::findOrFail($id);
        $company = Company::where('id_user', $id)->first();

        $mergedData = new \stdClass();
        foreach ($company->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        return $mergedData;
    }

    /**
     * @OA\Get(
     *     path="/api/checkCIF/{CIF}",
     *     summary="Verificar CIF de la empresa",
     *     description="Verifica si el CIF proporcionado pertenece a alguna empresa registrada",
     *     operationId="checkCIF",
     *     tags={"Company"},
     *     @OA\Parameter(
     *         name="CIF",
     *         in="path",
     *         description="Número de identificación fiscal (CIF) de la empresa",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="boolean",
     *             example=true,
     *             description="Indica si el CIF pertenece a una empresa registrada (true) o no (false)"
     *         )
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="No autorizado"
     *     )
     * )
     */
    public function checkCIF($CIF){
        $company = Company::where('CIF', $CIF)->first();
        return $company !== null;
    }

    /**
     * @OA\Get(
     *     path="/api/companyCIF/{CIF}",
     *     summary="Obtener empresa por CIF",
     *     description="Obtiene los detalles de una empresa basándose en su CIF",
     *     operationId="getCompanyCIF",
     *     tags={"Company"},
     *     @OA\Parameter(
     *         name="CIF",
     *         in="path",
     *         description="CIF (Código de Identificación Fiscal) de la empresa",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Company"
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
     *                 example="Empresa no encontrada para el CIF proporcionado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="No autorizado"
     *     )
     * )
     */

    public function getCompanyCIF($CIF) {
        $company = Company::where('CIF', $CIF)->first();

        if ($company) {
            return new CompanyResource($company);
        } else {
            return response()->json(['message' => 'Empresa no encontrada para el CIF proporcionado'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/companyEmail/{email}",
     *     summary="Obtener empresa por correo electrónico del usuario",
     *     description="Obtiene los detalles de una empresa basándose en el correo electrónico del usuario asociado",
     *     operationId="getCompanyByEmail",
     *     tags={"Company"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Correo electrónico del usuario asociado a la empresa",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="email"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example="1"),
     *             @OA\Property(property="CIF", type="string", example="ABC123"),
     *             @OA\Property(property="companyName", type="string", example="Empresa XYZ"),
     *             @OA\Property(property="direccion", type="string", example="Calle Principal 123"),
     *             @OA\Property(property="CP", type="string", example="12345"),
     *             @OA\Property(property="telefono", type="string", example="123-456-7890"),
     *             @OA\Property(property="web", type="string", example="https://www.empresa.com")
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
     *                 example="No se encontró ninguna empresa para el correo electrónico proporcionado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */


    public function getCompanyByEmail($email)
    {
        $user = User::where('email',$email)->first();
        $company = Company::where('id_user', $user->id)->first();

        $data = new \stdClass();
        foreach ($company->getAttributes() as $key => $value) {
            $data->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            if ($key === 'password') {
                continue;
            }
            $data->$key = $value ?? '';
        }

        return $data;
    }
}
