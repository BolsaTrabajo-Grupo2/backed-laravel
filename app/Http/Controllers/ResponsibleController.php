<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResponsibleController extends Controller
{
    public function index()
    {
        $responsibles = User::where('rol',"RESP")->paginate(10);
        return view('responsible.index', compact('responsibles'));
    }
    public function show($id)
    {
        $responsible = User::find($id);
        return view('responsible.show', ['responsible' => $responsible]);
    }
    public function create()
    {
        return view('responsible.create');
    }
    public function store(UserUpdateRequest $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->surname = $request->get('surname');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->rol = $request->get('rol');

        $user->save();

        $token = $user->createToken('api-token')->plainTextToken;
        return redirect()->route('responsible.index')->with('success', 'Responsable añadido correctamente.');
    }

    public function edit($id)
    {
        $responsible = User::find($id);
        if (!$responsible) {
            return abort(404);
        }

        return view('responsible.edit', compact('responsible'));
    }



    public function update(UserRequest $request, $id)
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
        $user->rol = $request->get('rol');

        $user->save();

        return redirect()->route('responsible.show', $user->id)->with('success', 'Responsable añadido correctamente.');
    }
    public function destroy($id)
    {
        try {
            $responsible = User::find($id);

            if (!$responsible) {
                return abort(404);
            }
            $responsible->delete();
            return redirect()->route('responsible.index')->with('success', 'Responsable eliminado correctamente.');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->route('responsible.index')->with('error', 'No se puede eliminar el responsable debido a restricciones de clave externa.');
            } else {
                return redirect()->route('responsible.index')->with('error', 'Error al eliminar el responsable.');
            }
        }
    }
}
