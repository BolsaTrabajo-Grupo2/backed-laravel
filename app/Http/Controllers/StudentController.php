<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateBackendRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Apply;
use App\Models\Cycle;
use App\Models\Offer;
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
        $cursedCycles = Cycle::join('studies', 'cycles.id', '=', 'studies.id_cycle')
            ->where('studies.id_student', $id)
            ->get();
        $student = Student::find($id);
        return view('student.show', ['student' => $student,'cursedCycles' => $cursedCycles]);
    }
    public function offers($id)
    {
        $appliesData = Apply::where('id_student', '=', $id)
            ->with('offer')
            ->get();
        $offersData = $appliesData->pluck('offer');
        return view('student.offers', ['offers' => $offersData,'idStudent' => $id]);
    }
    public function offerShow($id, $idStudent)
    {
        $offer = Offer::find($id);
        return view('student.offersShow', ['offer' => $offer, 'idStudent' => $idStudent]);
    }
    public function create()
    {
        $cycles = Cycle::all();
        return view('student.create', compact('cycles'));
    }
    public function store(StudentRequest $studentRequest)
    {
        $userResponse = UserApiController::register($studentRequest);
        $user = $userResponse->getOriginalContent()['user'];
        $student = new Student();
        $student->id_user = $user->id;
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->observations = $studentRequest->get('observations');
        $student->created_at = Carbon::now();
        $student->updated_at = Carbon::now();
        $student->accept = true;
        $student->save();
        $cycles = $studentRequest->get('cycles');
        $dates = $studentRequest->get('dates');
        foreach ($cycles as $index => $cycle) {
            if (!empty($cycle)) {
                $study = new Study();
                $study->id_student = $student->id;
                $study->id_cycle = $cycle;
                $study->date = $dates[$index];
                $study->verified = true;
                $study->save();
                $cycleModel = Cycle::findOrFail($study->id_cycle);
                $responsible = User::findOrFail($cycleModel->id_responsible);
            }
        }
        return redirect()->route('student.index')->with('success', 'Studiante añadido correctamente.');
    }

    public function edit($id)
    {
        $cycles = Cycle::all();
        $student = Student::where('id_user', $id)->firstOrFail();
        if (!$student) {
            return abort(404);
        }
        return view('student.edit', compact('student','cycles'));
    }
    public function update(StudentUpdateBackendRequest $studentRequest, $id)
    {
        $userApi = new UserApiController();
        $userResponse = $userApi->update($studentRequest, $id);

        $student = Student::where('id_user', $id)->firstOrFail();
        $student->address = $studentRequest->input("address");
        $student->cv_link = $studentRequest->input("CVLink");
        $student->observations = $studentRequest->input('observations');
        $student->updated_at = now();
        $student->accept = true;
        $student->save();

        $existingStudies = Study::where('id_student', $student->id)->pluck('id_cycle')->toArray();
        $sentCycles = $studentRequest->input('cycles');

        $cyclesToDelete = array_diff($existingStudies, $sentCycles);

        Study::where('id_student', $student->id)
            ->whereIn('id_cycle', $cyclesToDelete)
            ->delete();

        foreach ($studentRequest->input('cycles') as $index => $selectedCycle) {
            if (!empty($selectedCycle)) {
                $existingStudy = Study::updateOrCreate(
                    ['id_student' => $student->id, 'id_cycle' => $selectedCycle],
                    ['date' => $studentRequest->input('dates')[$index]],
                    ['verified' => true]
                );


                if (!in_array($selectedCycle, $existingStudies)) {
                    $cycleModel = Cycle::findOrFail($selectedCycle);
                    $responsible = User::findOrFail($cycleModel->id_responsible);
                }
            }
        }

        return redirect()->route('student.show', $student->id)
            ->with('success', 'Estudiante actualizado correctamente.');
    }



    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'No se ha encontrado el estudiante'], 404);
        }

        $userId = $student->id_user;

        $student->delete();

        User::where('id', $userId)->delete();
        return redirect()->route('student.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
