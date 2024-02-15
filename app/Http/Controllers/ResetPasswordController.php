<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($email)
    {
        return view('emails.reset', ['email' => $email]);
    }
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return view('emails.success_password');
    }
}
