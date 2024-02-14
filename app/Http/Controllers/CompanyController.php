<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function edit($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return abort(404);
        }

        return view('company.edit', compact('company'));
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

        return redirect()->route('company.show', $company->id_user)->with('success', 'Compañia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $company = Company::find($id);

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
}
