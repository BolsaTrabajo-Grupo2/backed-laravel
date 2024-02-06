<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CycleCollection;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;


class CycleApiController extends Controller
{
    public function index(){
        $cycles = Cycle::all()->paginate(10);
        return new CycleCollection($cycles);
    }
    public function show(Cycle $cycle)
    {
        return new CycleResource($cycle);
    }

    public function store(CycleRequest $request)
    {
        $company = new Company();
        $company->CIF = $request->get('CIF');
        $company->user_id = $request->get('idUser');
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->save();
        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->CIF = $request->get('CIF');
        $company->user_id = $request->get('idUser');
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');

        $company->save();

        return new CompanyResource($company);
    }


}
