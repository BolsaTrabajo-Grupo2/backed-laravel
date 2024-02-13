<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRquest;
use App\Models\Apply;
use App\Models\Cycle;
use App\Models\Student;
use App\Models\Study;
use App\Models\User;
use App\Notifications\CycleValidationRequest;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::withCount('applies')->paginate(10);
        return view('student.index', compact('students'));
    }
    public function show($id)
    {
        $student = Student::find($id);
        return view('student.show', ['student' => $student]);
    }
    public function create()
    {
        return view('student.create');
    }
    public function store(StudentRequest $studentRequest)
    {

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
        foreach ($studentRequest->get('cycle') as $cycle) {
            if (!empty($cycle['selectedCycle'])) {
                $study = new Study();
                $study->id_student = $student->id;
                $study->id_cycle = $cycle['selectedCycle'];
                $study->date = $cycle['date'];
                $study->save();
                $cycle = Cycle::findOrFail($study->id_cycle);
                $responsible = User::findOrFail($cycle->id_responsible);
                $responsible->notify(new CycleValidationRequest($study, $user->name));
            }
        }
        $studies = Study::where('id_student', $student->id)->get();
        $user->notify(new NewStudentOrCompanyNotification($student, $studies));

        return redirect()->route('student.index')->with('success', 'Studiante añadido correctamente.');
    }

    public function edit(StudentUpdateRquest $studentRequest, $id)
    {
        $userApi = new UserApiController();
        $userResponse = $userApi->update($studentRequest,$id);
        $student = Student::where('id_user', $id)->firstOrFail();
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->observations = $studentRequest->get('observations');
        $student->updated_at = Carbon::now();
        $student->save();
        $studies = Study::where('id_student', $student->id)->pluck('id_cycle')->toArray();
        foreach ($studentRequest->get('cycle') as $cycle) {
            $selectedCycle = $cycle['selectedCycle'];
            if (!empty($selectedCycle)) {
                if (in_array($selectedCycle, $studies)) {
                    $existingStudy = Study::where('id_student', $student->id)
                        ->where('id_cycle', $selectedCycle)
                        ->first();
                    if ($existingStudy) {
                        $existingStudy->date = $cycle['date'];
                        $existingStudy->save();
                    }
                } else {
                    $study = new Study();
                    $study->id_student = $student->id;
                    $study->id_cycle = $selectedCycle;
                    $study->date = $cycle['date'];
                    $study->save();
                    $cycleModel = Cycle::findOrFail($selectedCycle);
                    $responsible = User::findOrFail($cycleModel->id_responsible);
                    $responsible->notify(new CycleValidationRequest($study, $userResponse->name));
                }
            }
        }

        return view('student.edit', compact('student'));
    }
    public function update(StudentRequest $request, $id)
    {

        $student = Student::find($id);

        if (!$student) {
            return abort(404);
        }

        $student->update($request);

        return redirect()->route('student.show', $student->id)->with('success', 'Student actualizado correctamente.');
    }
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'No se ha encontrado el estudiante'], 404);
        }

        $userId = $student->id_user;

        Apply::where('id_student', $id)->delete();

        $student->delete();

        User::where('id', $userId)->delete();
        return redirect()->route('student.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
