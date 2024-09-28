<?php

namespace Modules\Students\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Students\Models\Student;
use Modules\Students\Models\Enrollment;
use Modules\classes\Models\Subject;
use Modules\Students\Services\PaymentService;

class StudentsController extends Controller
{
    public function register(Request $request)
    {
        $student = Student::create($request->all());
        $enrollment = Enrollment::create([
            'student_id' => $student->id,
            'class_id' => $request->input('class_id'),
        ]);

        $subjects = $request->input('subjects');
        foreach ($subjects as $subjectId) {
            $subject = Subject::find($subjectId);
            $enrollment->subjects()->attach($subject);
        }

        $paymentService = new PaymentService();
        $paymentService->processPayment($enrollment);

        return response()->json(['message' => 'Student registered successfully']);
    }
}
