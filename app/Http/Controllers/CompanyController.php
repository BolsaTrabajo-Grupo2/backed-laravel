<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateBackendRequest;
use App\Models\Company;
use App\Models\User;
use App\Notifications\ActivedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);

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

        return redirect()->route('company.index')->with('success', 'Compañia añadida correctamente.');
    }

    public function edit($CIF)
    {
        $company = Company::where('CIF', $CIF)->firstOrFail();
        return view('company.edit', compact('company'));
    }


    public function update(CompanyUpdateBackendRequest $request, $userId)
    {
        $userApi = new UserApiController();
        $companyResponse = $userApi->update($request, $userId);

        $company = Company::where('id_user', $userId)->firstOrFail();
        $company->CIF = $request->get('CIF');
        $company->address = $request->get('address');
        $company->phone = $request->get('phone');
        $company->web = $request->get('web');
        $company->company_name = $request->get('company_name');
        $company->CP = $request->get('CP');
        $company->updated_at = now();
        $company->save();

        return redirect()->route('company.show', $company)->with('success', 'Compañía actualizada correctamente.');
    }



    public function destroy($id)
    {
        $company = Company::find($id)->first();

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

            return redirect()->route('company.index')->with('success', 'Compañía y usuario eliminados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('company.index')->with('error', 'Error al eliminar la compañía y el usuario.');
        }
    }
    public function accept($id){
        $user = User::findOrFail($id);
        $user->accept = true;
        $user->save();
        $user->notify(new ActivedNotification());
        return redirect()->route('company.index')->with('success', 'Empresa validada correctamente.');
    }
}
