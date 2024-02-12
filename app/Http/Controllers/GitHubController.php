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
            $existingUser = User::where('email', 'like', '%' . $user->email . '%')->first();
            if ($existingUser) {
                Auth::login($existingUser);
            }

        } catch (Exception $e){
            alert($e->getMessage());
        }
    }
}
