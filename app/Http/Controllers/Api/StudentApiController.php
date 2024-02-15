<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRquest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Apply;
use App\Models\Cycle;
use App\Models\Student;
use App\Models\Study;
use App\Models\User;
use App\Notifications\ActivedNotification;
use App\Notifications\CycleValidationRequest;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Type\TrueType;


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
        return response()->json(['token' => $token], 201);
    }

    public function update(StudentUpdateRquest $studentRequest, $id){
        $userApi = new UserApiController();
        $userResponse = $userApi->update($studentRequest,$id);
        $student = Student::where('id_user', $id)->firstOrFail();
        $student->address = $studentRequest->get("address");
        $student->cv_link = $studentRequest->get("CVLink");
        $student->observations = $studentRequest->get('observations');
        $student->updated_at = Carbon::now();
        $student->save();
        $studies = Study::where('id_student', $student->id)->pluck('id_cycle')->toArray();

        $existingStudies = Study::where('id_student', $student->id)->pluck('id_cycle')->toArray();

        $sentCycles = collect($studentRequest->get('cycle'))->pluck('selectedCycle')->toArray();

        $cyclesToDelete = array_diff($existingStudies, $sentCycles);

        Study::where('id_student', $student->id)
            ->whereIn('id_cycle', $cyclesToDelete)
            ->delete();

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
        return new StudentResource($student);
    }
    public function delete($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'No se ha encontrado el estudiante'], 404);
        }

        $userId = $student->id_user;

        Apply::where('id_student', $id)->delete();

        $student->delete();

        User::where('id', $userId)->delete();
        return response()->json([
            'message' => 'El estudiante con id:' . $id . ' ha sido borrado con éxito',
            'data' => $id
        ], 200);
    }
    public function active($id){
        $student = Student::findOrFail($id);
        $student->accept = true;
        $student->save();
        $user = User::findOrFail($student->id_user);
        $user->notify(new ActivedNotification());
        return view('users.actived');
    }
    public function getStudent($id) {
        $user = User::findOrFail($id);
        $student = Student::where('id_user', $id)->first();

        $mergedData = new \stdClass();
        foreach ($student->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            if ($key === 'password' || $key === 'email') {
                continue;
            }
            $mergedData->$key = $value ?? '';
        }

        return $mergedData;
    }
    public function getCycleByStudent($id){
        $student = Student::where('id_user', $id)->first();
        $studies = Study::where('id_student', $student->id)->get();
        $cycles = [];
        foreach ($studies as $study) {
            $cycles[] = [
                'id' => $study->id_cycle,
                'selectedCycle' => $study->id_cycle,
                'date' => $study->date
            ];
        }
        return $cycles;
    }
    public function verificated($id){
        $study = Study::findOrFail($id);
        $study->verified = true;
        $study->update();
        return 'verificado con exito';
    }
    public function signUp($idOffer){
        $user = Auth::user();
        $singUp = new Apply();
        $singUp->id_offer = $idOffer;
        $singUp->id_student = $user->id;
        $singUp->save();
    }
    public function showUserApplie($id){
        $applies = Apply::where('id_offer',$id);
        $users = [];
        foreach ($applies as $apply) {
            $student = Student::findOrFail($apply->id_student);
            $user = User::where('id_user',$student->id_user);
            $users = $user;
        }
        return $users;
    }

    public function getStudentByEmail($email)
    {
        $user = User::findOrFail($email)->first();
        $student = Student::where('id_user', $user->id)->first();

        $mergedData = new \stdClass();
        foreach ($student->getAttributes() as $key => $value) {
            $mergedData->$key = $value ?? '';
        }

        foreach ($user->getAttributes() as $key => $value) {
            if ($key === 'password' || $key === 'email') {
                continue;
            }
            $mergedData->$key = $value ?? '';
        }

        return $mergedData;
    }
}
