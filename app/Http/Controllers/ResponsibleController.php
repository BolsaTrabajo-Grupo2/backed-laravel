<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        $responsible = new User($validatedData);
        $responsible->rol = "RESP";
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
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        $responsible = User::find($id);

        if (!$responsible) {
            return abort(404);
        }

        $responsible->update($validatedData);

        return redirect()->route('responsible.show', $responsible->id)->with('success', 'Responsable añadido correctamente.');
    }
    public function destroy($id)
    {
        $responsible = User::find($id);

        if (!$responsible) {
            return abort(404);
        }

        $responsible->delete();

        return redirect()->route('responsible.index')->with('success', 'Responsable eliminado correctamente.');
    }
}
