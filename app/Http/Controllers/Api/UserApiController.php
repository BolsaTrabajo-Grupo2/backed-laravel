<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{

    public function index()
    {
        $users = Company::all()->paginate(10);
        return new UserCollection($users);
    }

    public function show(Company $company)
    {
        return new UserResource($company);
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->rol = $request->get('rol');

        $user->save();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'id' => $user->id], 201);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->rol = $request->get('rol');

        $user->save();

        return new UserResource($user);
    }


}
