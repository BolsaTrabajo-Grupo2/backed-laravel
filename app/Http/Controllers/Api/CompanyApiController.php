<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function store()
    {

    }
}
