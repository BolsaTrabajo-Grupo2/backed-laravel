<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;

class CompanyApiController extends Controller
{
    public function index()
    {
        $users = Company::all()->paginate(10);
        return new CompanyCollection($users);
    }

    public function show(User $user)
    {
        return new CompanyResource($user);
    }

    public function store()
    {

    }
}
