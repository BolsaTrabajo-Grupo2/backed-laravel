<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyApiController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);
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
        $company->company_name = $request->get('company_name');
        $company->CP = $request->get('CP');
        $company->created_at = Carbon::now();
        $company->updated_at = Carbon::now();
        $company->save();
        $user->notify(new NewStudentOrCompanyNotification($user));
        return response()->json(['token' => $token], 201);
    }

    public function update(CompanyUpdateRequest $request, $id)
    {
        $userApi = new UserApiController();
        $companyResponse = $userApi->update($request,$id);
        $company = Company::where('id_user',$id)->firstOrFail();
        $company->CIF = $request->get('CIF');
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->company_name = $request->get('company_name');
        $company->CP = $request->get('CP');
        $company->updated_at = Carbon::now();
        $company->save();
        return new CompanyResource($company);
    }

    public function delete($cif)
    {
        $company = Company::where('CIF',$cif)->first();
        if (!$company) {
            return abort(404);
        }
        $userId = $company->id_user;
        DB::beginTransaction();
        try {
            $cifToDelete = $company->CIF;
            DB::table('offers')
                ->where('CIF', $cifToDelete)
                ->update(['CIF' => null]);
            $company->delete();
            DB::table('users')->where('id', $userId)->delete();
            DB::commit();
            return response()->json([
                'message' => 'La empresa con id:' . $userId . ' ha sido borrada con éxito',
                'data' => $userId
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'La empresa con id:' . $userId . ' no se ha podido borrar',
                'data' => $userId
            ], (500));
        }

    }
    public function getCompany($id) {
        $user = User::findOrFail($id);
        $company = Company::where('id_user', $id)->first();

        $mergedData = new \stdClass();
        foreach ($company->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        return $mergedData;
    }
    public function checkCIF($CIF){
        $company = Company::where('CIF', $CIF)->first();
        return $company !== null;
    }
    public function getCompanyCIF($CIF) {
        $company = Company::where('CIF', $CIF)->first();

        if ($company) {
            return new CompanyResource($company);
        } else {
            return response()->json(['message' => 'Empresa no encontrada para el CIF proporcionado'], 404);
        }
    }

    public function getCompanyByEmail($email)
    {
        $user = User::where('email',$email)->first();
        $company = Company::where('id_user', $user->id)->first();

        $data = new \stdClass();
        foreach ($company->getAttributes() as $key => $value) {
            $data->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            if ($key === 'password') {
                continue;
            }
            $data->$key = $value ?? '';
        }

        return $data;
    }
}
