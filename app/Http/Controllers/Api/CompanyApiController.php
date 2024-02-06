<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyApiController extends Controller
{
    public function index()
    {
        $companies = Company::all()->paginate(10);
        return new CompanyCollection($companies);
    }

    public function show(Company $company)
    {
        return new CompanyResource($company);
    }
    public function store(CompanyRequest $request)
    {
        $user = UserApiController::class->register($request);
        $company = new Company();
        $company->CIF = $request->get('CIF');
        $company->user_id = $user->id;
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->save();
        return response()->json(['token' => $user->token], 201);
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

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(null, 204);
    }
}
