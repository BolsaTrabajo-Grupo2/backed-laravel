<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Mail\ResetPasswordMail;
use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use App\Notifications\ActivedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Esquema para los datos de un usuario",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John"),
 *     @OA\Property(property="surname", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="rol", type="string", example="ADM"),
 * )
 * @OA\Schema(
 *     schema="UserCollection",
 *     title="UserCollection",
 *     description="Colección de recursos de usuario",
 *     @OA\Property(
 *         property="current_page",
 *         type="integer",
 *         example=1,
 *         description="Número de página actual"
 *     ),
 *     @OA\Property(
 *         property="total_pages",
 *         type="integer",
 *         example=5,
 *         description="Número total de páginas"
 *     ),
 *     @OA\Property(
 *         property="per_page",
 *         type="integer",
 *         example=10,
 *         description="Número de usuarios por página"
 *     ),
 *     @OA\Property(
 *         property="total_records",
 *         type="integer",
 *         example=50,
 *         description="Número total de usuarios"
 *     ),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/User"),
 *         description="Lista de usuarios"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         example="success",
 *         description="Estado de la operación"
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(
 *             property="prev",
 *             type="string",
 *             example="/api/users?page=1",
 *             description="Enlace a la página anterior"
 *         ),
 *         @OA\Property(
 *             property="next",
 *             type="string",
 *             example="/api/users?page=3",
 *             description="Enlace a la página siguiente"
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="UserResource",
 *     title="UserResource",
 *     description="Esquema para los datos de un usuario",
 *     @OA\Property(property="id", type="integer", example="1", description="ID único del usuario"),
 *     @OA\Property(property="name", type="string", example="John", description="Nombre del usuario"),
 *     @OA\Property(property="surname", type="string", example="Doe", description="Apellido del usuario"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Correo electrónico del usuario"),
 *     @OA\Property(property="rol", type="string", example="ADM", description="Rol del usuario")
 * )
 */


class UserApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Obtener una lista paginada de usuarios",
     *     description="Este endpoint devuelve una lista paginada de usuarios.",
     *     operationId="index",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/UserCollection")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function index()
    {
        $users = User::paginate(10);
        return new UserCollection($users);
    }
    /**
     * @OA\Get(
     *     path="/api/users/{user}",
     *     summary="Obtener detalles de una empresa",
     *     description="Este endpoint devuelve los detalles de una empresa específica.",
     *     operationId="showCompany",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="users",
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
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Empresa no encontrada"
     *             )
     *         )
     *     )
     * )
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     description="Este endpoint permite registrar un nuevo usuario en el sistema.",
     *     operationId="registerUser",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del usuario a registrar",
     *         @OA\JsonContent(
     *             required={"name", "surname", "email", "password", "rol"},
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="surname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="rol", type="string", example="ADM"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 description="Token de acceso generado para el usuario",
     *                 example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Detalles del usuario registrado",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada inválidos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Los datos de entrada son inválidos o están incompletos."
     *             )
     *         )
     *     )
     * )
     */
    public static function register(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->rol = $request->get('rol');

        $user->save();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Actualizar usuario por ID",
     *     description="Actualiza los detalles de un usuario basándose en su ID",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del usuario a actualizar",
     *         @OA\JsonContent(
     *             required={"name", "surname"},
     *             @OA\Property(property="name", type="string", example="John", description="Nuevo nombre del usuario"),
     *             @OA\Property(property="surname", type="string", example="Doe", description="Nuevo apellido del usuario"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Nuevo correo electrónico del usuario"),
     *             @OA\Property(property="password", type="string", example="nuevapassword", description="Nueva contraseña del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/User"
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
     *                 example="El usuario no fue encontrado"
     *             )
     *         )
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        if($request->get('email')){
            $user->email = $request->get('email');
        }
        if($request->get('password') != '' ){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        return new UserResource($user);
    }
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Eliminar usuario por ID",
     *     description="Elimina un usuario basándose en su ID",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a eliminar",
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
     *                 example="El usuario con id: {id} ha sido borrado con éxito"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="integer",
     *                 example="{id}",
     *                 description="ID del usuario borrado"
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
     *                 example="No se ha encontrado el usuario"
     *             )
     *         )
     *     )
     * )
     */

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'No se ha encontrado el usuario'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'El usuario con id:' . $id . ' ha sido borrada con éxito',
            'data' => $id
        ], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/checkEmail/{email}",
     *     summary="Verificar si existe un usuario con el correo electrónico dado",
     *     description="Comprueba si hay un usuario registrado con el correo electrónico proporcionado",
     *     operationId="checkEmail",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Correo electrónico del usuario a verificar",
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
     *             type="boolean",
     *             example="true",
     *             description="Indica si existe un usuario con el correo electrónico proporcionado"
     *         )
     *     )
     * )
     */

    public function checkEmail($email){
        $user = User::where('email', $email)->first();
        return $user !== null;
    }
    /**
     * @OA\Post(
     *     path="/api/sendEmail/{email}",
     *     summary="Enviar correo electrónico de restablecimiento de contraseña",
     *     description="Envía un correo electrónico de restablecimiento de contraseña al usuario con el correo electrónico proporcionado.",
     *     operationId="sendEmail",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de entrada",
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Correo electrónico enviado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */

    public function  sendEmail($email){
        $user = User::where('email',$email)->first();
        if($user->rol == 'ADM'){
            throw new \Exception('El usuario es un administrador.');
        }
        Mail::to($user->email)->send(new ResetPasswordMail($user));

    }
    /**
     * @OA\Put(
     *     path="/api/active/{id}",
     *     summary="Activar usuario",
     *     description="Activa un usuario con el ID proporcionado.",
     *     operationId="activateUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a activar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario activado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */


    public function active($id){
        $user = User::findOrFail($id);
        $user->accept = true;
        $user->save();
        $user->notify(new ActivedNotification());
        return view('users.actived');
    }
}
