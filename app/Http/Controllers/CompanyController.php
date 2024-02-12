<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all()->paginate(10);
        return view('company.index', compact('companies'));
    }
    public function show($id)
    {
        $company = Company::find($id);
        return view('company.show', ['company' => $company]);
    }
    public function create()
    {
        return view('company.create');
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'CIF' => 'required|string|size:9',
            'company_name' => 'required|string|max:100',
            'address' => 'required|string|max:250',
            'CP' => 'required|string|size:5',
            'phone' => 'required|string|size:9',
            'web' => 'nullable|string|max:100|url',
        ]);

        $company = new Company($validatedData);
        $company->rol = "COMP";
        $company->save();

        return redirect()->route('company.index')->with('success', 'Compañia añadida correctamente.');
    }

    public function edit($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return abort(404);
        }

        return view('company.edit', compact('company'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'CIF' => 'required|string|size:9',
            'company_name' => 'required|string|max:100',
            'address' => 'required|string|max:250',
            'CP' => 'required|string|size:5',
            'phone' => 'required|string|size:9',
            'web' => 'nullable|string|max:100|url',
            'rol' => 'required',
        ]);

        $company = Company::find($id);

        if (!$company) {
            return abort(404);
        }

        $company->update($validatedData);

        return redirect()->route('company.show', $company->id_user)->with('success', 'Compañia actualizada correctamente.');
    }
    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return abort(404);
        }

        $company->delete();

        return redirect()->route('company.index')->with('success', 'Compañia eliminada correctamente.');
    }
}
