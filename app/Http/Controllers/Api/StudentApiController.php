<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;


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
        $userResponse = UserApiController::register($studentRequest);
        $user = $userResponse->getOriginalContent()['user'];
        $token = $userResponse->getOriginalContent()['token'];
        $student = new Student();
        $student->id_user = $user->id;
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->created_at = Carbon::now();
        $student->updated_at = Carbon::now();
        $student->save();
        $user->notify(new NewStudentOrCompanyNotification());
        return response()->json(['token' => $token], 201);
    }

    public function update(StudentRequest $studentRequest, $id){
        $student = Student::findOrFail($id);
        $student->id_user = $studentRequest->get("idUser");
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->updated_at = Carbon::now();
        $student->save();
        return new StudentResource($student);
    }
    public function delete($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'No se ha encontrado el estudiante'], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'El estudiante con id:' . $id . ' ha sido borrado con éxito',
            'data' => $id
        ], 200);
    }
}
