<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Apply;
use App\Models\Cycle;
use App\Models\Student;
use App\Models\Study;
use App\Models\User;
use App\Notifications\ActivedNotification;
use App\Notifications\CycleValidationRequest;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Type\TrueType;

/**
 * @OA\Schema(
 *     schema="Student",
 *     title="Student",
 *     description="Esquema para los datos de un estudiante",
 *     required={"id_user", "address"},
 *     @OA\Property(property="id_user", type="integer", description="ID del usuario asociado al estudiante"),
 *     @OA\Property(property="address", type="string", description="Dirección del estudiante"),
 *     @OA\Property(property="cv_link", type="string", nullable=true, description="Enlace al curriculum vitae del estudiante"),
 *     @OA\Property(property="observations", type="string", nullable=true, description="Observaciones sobre el estudiante")
 * )
 * @OA\Schema(
 *     schema="StudentResource",
 *     title="Student",
 *     description="Esquema para los datos de un estudiante",
 *     required={"id", "idUser", "address", "CVLink", "accept"},
 *     @OA\Property(property="id", type="integer", example=1, description="ID del estudiante"),
 *     @OA\Property(property="idUser", type="integer", example=1, description="ID del usuario asociado"),
 *     @OA\Property(property="address", type="string", maxLength=100, example="123 Main St", description="Dirección del estudiante"),
 *     @OA\Property(property="CVLink", type="string", maxLength=75, example="https://example.com/cv", description="Enlace al currículum vitae del estudiante"),
 * )
 */


class StudentApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/students",
     *     summary="Obtener todos los estudiantes",
     *     description="Obtiene todos los estudiantes disponibles",
     *     operationId="getAllStudents",
     *     tags={"Students"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="total_pages", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total_records", type="integer", example=50),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Student")),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(property="prev", type="string", example="url_prev_page"),
     *                 @OA\Property(property="next", type="string", example="url_next_page")
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
        $student = Student::all()->paginate(10);
        return new StudentCollection($student);
    }
    /**
     * Muestra los detalles de un estudiante.
     *
     * @OA\Get(
     *     path="/api/students/{id}",
     *     summary="Obtener detalles de un estudiante",
     *     description="Devuelve los detalles de un estudiante específico.",
     *     operationId="getStudentById",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudiante a obtener detalles",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Student")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Estudiante no encontrado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function show(Student $student)
    {
        return new StudentResource($student);
    }
    /**
     * Almacena un nuevo estudiante en el sistema.
     *
     * @OA\Post(
     *     path="/api/students",
     *     summary="Crear un nuevo estudiante",
     *     description="Crea un nuevo estudiante en el sistema.",
     *     operationId="storeStudent",
     *     tags={"Students"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del estudiante a crear",
     *         @OA\JsonContent(
     *             required={"name", "surname", "email", "password", "rol", "address"},
     *             @OA\Property(property="name", type="string", maxLength=250, example="John"),
     *             @OA\Property(property="surname", type="string", maxLength=250, example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", minLength=8, example="password123"),
     *             @OA\Property(property="rol", type="string", example="STU"),
     *             @OA\Property(property="address", type="string", maxLength=100, example="123 Main St"),
     *             @OA\Property(property="CVLink", type="string", maxLength=75, example="https://example.com/cv"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estudiante creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", example="generated_token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Los datos de entrada no son válidos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */

    public function store(StudentRequest $studentRequest){
        $userResponse = UserApiController::register($studentRequest);
        $user = $userResponse->getOriginalContent()['user'];
        $token = $userResponse->getOriginalContent()['token'];
        $student = new Student();
        $student->id_user = $user->id;
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->created_at = Carbon::now();
        $student->updated_at = Carbon::now();
        $student->save();
        foreach ($studentRequest->get('cycle') as $cycle) {
            if (!empty($cycle['selectedCycle'])) {
                $study = new Study();
                $study->id_student = $student->id;
                $study->id_cycle = $cycle['selectedCycle'];
                $study->date = $cycle['date'];
                $study->save();
                $cycle = Cycle::findOrFail($study->id_cycle);
                $responsible = User::findOrFail($cycle->id_responsible);
                $responsible->notify(new CycleValidationRequest($study, $user->name));
            }
        }
        $studies = Study::where('id_student', $student->id)->get();
        $user->notify(new NewStudentOrCompanyNotification($user, $studies));
        return response()->json(['token' => $token], 201);
    }
    /**
     * Actualiza los datos de un estudiante existente en el sistema.
     *
     * @OA\Put(
     *     path="/api/students/{id}",
     *     summary="Actualizar estudiante",
     *     description="Actualiza los datos de un estudiante existente en el sistema.",
     *     operationId="updateStudent",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudiante a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos actualizados del estudiante",
     *         @OA\JsonContent(
     *             required={"name", "surname", "rol", "address"},
     *             @OA\Property(property="name", type="string", maxLength=250, example="John"),
     *             @OA\Property(property="surname", type="string", maxLength=250, example="Doe"),
     *             @OA\Property(property="rol", type="string", example="STU"),
     *             @OA\Property(property="address", type="string", maxLength=100, example="123 Main St"),
     *             @OA\Property(property="CVLink", type="string", maxLength=75, example="https://example.com/cv"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estudiante actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/StudentResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estudiante no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Los datos de entrada no son válidos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function update(StudentUpdateRequest $studentRequest, $id){
        $userApi = new UserApiController();
        $userResponse = $userApi->update($studentRequest,$id);
        $student = Student::where('id_user', $id)->firstOrFail();
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->observations = $studentRequest->get('observations');
        $student->updated_at = Carbon::now();
        $student->save();
        $studies = Study::where('id_student', $student->id)->pluck('id_cycle')->toArray();

        $existingStudies = Study::where('id_student', $student->id)->pluck('id_cycle')->toArray();

        $sentCycles = collect($studentRequest->get('cycle'))->pluck('selectedCycle')->toArray();

        $cyclesToDelete = array_diff($existingStudies, $sentCycles);

        Study::where('id_student', $student->id)
            ->whereIn('id_cycle', $cyclesToDelete)
            ->delete();

        foreach ($studentRequest->get('cycle') as $cycle) {
            $selectedCycle = $cycle['selectedCycle'];
            if (!empty($selectedCycle)) {
                if (in_array($selectedCycle, $studies)) {
                    $existingStudy = Study::where('id_student', $student->id)
                        ->where('id_cycle', $selectedCycle)
                        ->first();
                    if ($existingStudy) {
                        $existingStudy->date = $cycle['date'];
                        $existingStudy->save();
                    }
                } else {
                    $study = new Study();
                    $study->id_student = $student->id;
                    $study->id_cycle = $selectedCycle;
                    $study->date = $cycle['date'];
                    $study->save();
                    $cycleModel = Cycle::findOrFail($selectedCycle);
                    $responsible = User::findOrFail($cycleModel->id_responsible);
                    $responsible->notify(new CycleValidationRequest($study, $userResponse->name));
                }
            }
        }
        return new StudentResource($student);
    }
    /**
     * @OA\Delete(
     *     path="/api/students/{id}",
     *     summary="Eliminar estudiante",
     *     description="Elimina un estudiante y su usuario asociado",
     *     operationId="deleteStudent",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudiante a eliminar",
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
     *                 example="El estudiante con id: 1 ha sido borrado con éxito"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="integer",
     *                 example=1,
     *                 description="ID del estudiante eliminado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No se ha encontrado el estudiante"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function delete($id)
    {
        $student = Student::where('id_user', $id)->first();
        $studentId = $student->id;
        if (!$student) {
            return response()->json(['error' => 'No se ha encontrado el estudiante'], 404);
        }

        Apply::where('id_student', $studentId)->delete();

        $student->delete();

        User::where('id', $id)->delete();
        return response()->json([
            'message' => 'El estudiante con id:' . $studentId . ' ha sido borrado con éxito',
            'data' => $studentId
        ], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/students/{idUser}",
     *     summary="Obtener estudiante por ID de usuario",
     *     description="Obtiene los detalles de un estudiante basándose en su ID de usuario",
     *     operationId="getStudentByIdUser",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario asociado al estudiante",
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
     *                 property="id",
     *                 type="integer",
     *                 example=1,
     *                 description="ID del estudiante"
     *             ),
     *             @OA\Property(
     *                 property="idUser",
     *                 type="integer",
     *                 example=1,
     *                 description="ID del usuario asociado al estudiante"
     *             ),
     *             @OA\Property(
     *                 property="address",
     *                 type="string",
     *                 example="Calle Principal 123",
     *                 description="Dirección del estudiante"
     *             ),
     *             @OA\Property(
     *                 property="CVLink",
     *                 type="string",
     *                 example="https://example.com/cv",
     *                 description="Enlace al CV del estudiante"
     *             ),
     *             @OA\Property(
     *                 property="accept",
     *                 type="string",
     *                 example="true",
     *                 description="Aceptación del estudiante"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No se ha encontrado el estudiante"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function getStudent($id) {
        $user = User::findOrFail($id);
        $student = Student::where('id_user', $id)->first();

        $mergedData = new \stdClass();
        foreach ($student->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            if ($key === 'password' || $key === 'email') {
                continue;
            }
            $mergedData->$key = $value ?? '';
        }

        return $mergedData;
    }
    /**
     * @OA\Get(
     *     path="/api/studentCicles/{id}",
     *     summary="Obtener ciclos por estudiante",
     *     description="Obtiene los ciclos en los que está inscrito un estudiante basándose en su ID de usuario",
     *     operationId="getCyclesByStudent",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario asociado al estudiante",
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
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID del ciclo"
     *                 ),
     *                 @OA\Property(
     *                     property="selectedCycle",
     *                     type="integer",
     *                     example=1,
     *                     description="ID del ciclo seleccionado"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string",
     *                     example="2024-02-20",
     *                     description="Fecha de inscripción en el ciclo"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No se ha encontrado el estudiante"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function getCycleByStudent($id){
        $student = Student::where('id_user', $id)->first();
        $studies = Study::where('id_student', $student->id)->get();
        $cycles = [];
        foreach ($studies as $study) {
            $cycles[] = [
                'id' => $study->id_cycle,
                'selectedCycle' => $study->id_cycle,
                'date' => $study->date
            ];
        }
        return $cycles;
    }
    /**
     * @OA\Put(
     *     path="/api/verificated/{id}",
     *     summary="Verificar estudio",
     *     description="Marca un estudio como verificado",
     *     operationId="verifyStudy",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estudio a verificar",
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
     *             type="string",
     *             example="verificado con exito",
     *             description="Mensaje de confirmación de verificación exitosa"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No se ha encontrado el estudio"
     *             )
     *         )
     *     )
     * )
     */
    public function verificated($id){
        $study = Study::findOrFail($id);
        $study->verified = true;
        $study->update();
        return 'verificado con exito';
    }
    /**
     * @OA\Post(
     *     path="/api/apply/{idOffer}",
     *     summary="Aplicar a una oferta",
     *     description="Aplica a una oferta específica",
     *     operationId="applyToOffer",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="idOffer",
     *         in="path",
     *         description="ID de la oferta a la que se desea aplicar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Aplicación creada con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Aplicación creada con éxito"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ya has aplicado a esta oferta"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function apply(Request $request, $idOffer) {
        $user = $request->user();
        $student = Student::where('id_user',$user->id)->first();
        $existingApplication = Apply::where('id_offer', $idOffer)
            ->where('id_student', $student->id)
            ->first();

        if ($existingApplication) {
            return response()->json(['error' => 'Ya has aplicado a esta oferta'], 400);
        }

        $application = new Apply();
        $application->id_offer = $idOffer;
        $application->id_student = $student->id;
        $application->save();

        return response()->json(['message' => 'Aplicación creada con éxito'], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/userOffert/{id}",
     *     summary="Mostrar usuarios que aplicaron a una oferta",
     *     description="Muestra los usuarios que han aplicado a una oferta específica",
     *     operationId="showUsersAppliedToOffer",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="idOffer",
     *         in="path",
     *         description="ID de la oferta para la cual se desean ver los usuarios que aplicaron",
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
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
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
     *                 example="No se encontraron usuarios que aplicaran a esta oferta"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function showUserApplie($idOffer){
        $applies =  Apply::where('id_offer',$idOffer)->get();
        $student = [];
        foreach ($applies as $applie){
            $s = Student::findOrFail($applie->id_student);
            $u = User::findOrFail($s->id_user);
            $student[] = $u;
        }
        return $student;
    }
    /**
     * @OA\Get(
     *     path="/api/studentEmail/{email}",
     *     summary="Obtener estudiante por correo electrónico",
     *     description="Obtiene los detalles de un estudiante basándose en su correo electrónico",
     *     operationId="getStudentByEmail",
     *     tags={"Students"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Correo electrónico del estudiante",
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
     *             type="object",
     *             @OA\Property(property="id", type="integer", example="1"),
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="surname", type="string", example="Doe"),
     *             @OA\Property(property="address", type="string", example="123 Main St"),
     *             @OA\Property(property="cv_link", type="string", example="https://example.com/cv"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
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
     *                 example="No se encontró ningún estudiante para el correo electrónico proporcionado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */

    public function getStudentByEmail($email)
    {
        $user = User::where('email',$email)->first();
        $student = Student::where('id_user', $user->id)->first();

        $data = new \stdClass();
        foreach ($student->getAttributes() as $key => $value) {
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
