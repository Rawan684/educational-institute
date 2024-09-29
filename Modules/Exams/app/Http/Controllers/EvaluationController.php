<?php

namespace Modules\Exams\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Modules\Students\Models\Student;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        foreach ($students as $student) {
            echo $student->average_grade . '<br>';
            echo $student->assignment_count . '<br>';
            echo $student->exam_count . '<br>';
            echo $student->evaluation_count . '<br>';
        }

        return response()->json($students);
    }

    public function show($id)
    {
        $student = Student::find($id);

        echo $student->average_grade . '<br>';
        echo $student->assignment_count . '<br>';
        echo $student->exam_count . '<br>';
        echo $student->evaluation_count . '<br>';

        if ($student->grade >= 60) {
            echo 'Pass';
        } else {
            echo 'Fail';
        }

        return response()->json($student);
    }
}
