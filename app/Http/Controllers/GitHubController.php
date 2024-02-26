<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Importar la clase Str correcta
use Laravel\Socialite\Facades\Socialite;
use Exception;
use function Laravel\Prompts\alert;

// Importar la clase Exception correcta

class GitHubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {

            $user = Socialite::driver('github')->user();


            $existingUser = User::where('email', $user->email)->first();

            if (!$existingUser) {
                return response()->json(['error' => 'No se encontró ningún usuario con este correo electrónico.'], 404);
            }

            Auth::login($existingUser);
            $token = $existingUser->createToken('GitHub Token')->plainTextToken;
            return redirect('https://bolsa-trabajo-backend.projecte02.ddaw.es?name=' . $user->name . '&email=' . $user->email . '&rol=' . $existingUser->rol . '&token=' . $token);

        } catch (Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error durante el proceso de autenticación.'], 500);
        }
    }
}
