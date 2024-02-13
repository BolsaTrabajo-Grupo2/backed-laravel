<?php

namespace App\Http\Controllers;

use App\Models\Assigned;
use App\Models\Cycle;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index($ciclo)
    {
        $assigneds = Assigned::where('id_cycle', $ciclo)->get();
        $offers = $assigneds->map(function ($assigned) {
            return $assigned->offer;
        });
        return view('offer.index', ['offers' => $offers]);
    }
    public function show($id)
    {
        $offer = Offer::find($id);
        return view('offer.show', ['offer' => $offer]);
    }
    public function create()
    {
        $cicles = Cycle::all();
        return view('offer.create',compact("cicles"));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'description' => 'required|string|max:200',
            'duration' => 'required|string|max:50',
            'responsibleName' => 'required|string|max:100',
            'inscriptionMethod' => 'required|boolean',
            'status' => 'required|boolean',
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
