<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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
    public function store(UserRequest $request)
    {
        $responsible = new User($request);
        $responsible->save();

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
        $responsible = User::find($id);

        if (!$responsible) {
            return abort(404);
        }

        $responsible->update($request);

        return redirect()->route('responsible.show', $responsible->id)->with('success', 'Responsable añadido correctamente.');
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
