<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Iniciar sesión",
 *     description="Inicio de sesión por correo electrónico y contraseña",
 *     operationId="authLogin",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Pasar credenciales de usuario",
 *         @OA\JsonContent(
 *            required={"email","password"},
 *            @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *            @OA\Property(property="password", type="string", format="password", example="Password12345")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Respuesta de credenciales incorrectas",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Lo siento, dirección de correo electrónico o contraseña incorrecta. Por favor, inténtalo de nuevo.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Respuesta exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="accept", type="boolean", example=true),
 *             @OA\Property(property="rol", type="string", example="admin"),
 *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
 *         )
 *     )
 * )
 */

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['name' => $user->name, 'email' => $user->email, 'accept' => $user->accept, 'rol' => $user->rol, 'token' => $token], 200);
    }
}
