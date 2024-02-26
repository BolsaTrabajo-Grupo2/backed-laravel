<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $localUser = User::where('email', $user->email)->first();
            if($localUser){
                $userBD = Auth::login($localUser);
                $token = $localUser->createToken('Personal Access Token')->plainTextToken;

                return redirect('https://www.bolsa-trabajo.projecte02.ddaw.es/?name=' . $userBD->name . '&email=' . $userBD->email . '&rol=' . $userBD->rol . '&token=' . $token);
            }
            return redirect('https://www.bolsa-trabajo.projecte02.ddaw.es/');
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Ha ocurrido un error durante el proceso de autenticación.'], 500);
        }
    }
}
