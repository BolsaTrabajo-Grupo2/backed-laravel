<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function index(){
        $student = Student::all()->paginate(10);
        return new StudentCollection($student);
    }
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    public function store(StudentRequest $studentRequest){
        $student = new Student();
        $student->idUser = $studentRequest->get("idUser");
        $student->address = $studentRequest->get("address");
        $student->CVLink = $studentRequest->get("CVLink");
        $student->accept = $studentRequest->get("accept");
        $student->save();
        return new StudentResource($student);
    }

    public function update(StudentRequest $studentRequest, $id){
        $student = Student::findOrFail($id);
        $student->idUser = $studentRequest->get("idUser");
        $student->address = $studentRequest->get("address");
        $student->CVLink = $studentRequest->get("CVLink");
        $student->accept = $studentRequest->get("accept");
        $student->save();
        return new StudentResource($student);
    }
}
