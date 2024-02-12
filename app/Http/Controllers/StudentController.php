<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all()->paginate(10);
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
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:100',
            'CVLink' => 'string|max:75',
        ]);

        $student = new Student($validatedData);
        $student->rol = "STU";
        $student->save();

        return redirect()->route('student.index')->with('success', 'Studiante añadido correctamente.');
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return abort(404);
        }

        return view('student.edit', compact('student'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'address' => 'required|string|max:100',
            'CVLink' => 'string|max:75',
        ]);

        $student = Student::find($id);

        if (!$student) {
            return abort(404);
        }

        $student->update($validatedData);

        return redirect()->route('student.show', $student->id)->with('success', 'Student actualizado correctamente.');
    }
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return abort(404);
        }
        $student->delete();
        return redirect()->route('student.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}
