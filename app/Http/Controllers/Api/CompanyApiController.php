<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Carbon\Carbon;

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
        $userResponse = UserApiController::register($request);
        $user = $userResponse->getOriginalContent()['user'];
        $token = $userResponse->getOriginalContent()['token'];
        $company = new Company();
        $company->CIF = $request->get('CIF');
        $company->id_user = $user->id;
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->created_at = Carbon::now();
        $company->updated_at = Carbon::now();
        $company->save();
        return response()->json(['token' => $token], 201);
    }

    public function update(CompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->CIF = $request->get('CIF');
        $company->user_id = $request->get('idUser');
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->updated_at = Carbon::now();

        $company->save();

        return new CompanyResource($company);
    }

    public function delete($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => 'No se ha encontrado la empresa'], 404);
        }

        $company->delete();

        return response()->json([
            'message' => 'La empresa con id:' . $id . ' ha sido borrada con éxito',
            'data' => $id
        ], 200);
    }
}
