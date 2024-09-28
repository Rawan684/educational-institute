<?php

namespace Modules\Exams\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Modules\Exams\Models\Exam;
use  Modules\Exams\Models\Question;
use  Modules\Exams\Models\Submission;
use  Modules\Exams\Models\Option;
use Modules\Students\Models\Student;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\AuthManager;
use Modules\Exams\Helpers\ExamHelper;
use App\Models\User;

class ExamsController extends Controller
{

    protected $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function publishExam(Request $request)
    {
        if (!Gate::allows('is-authenticated')) {
            return response()->json(['message' => 'You are not authenticated'], 401);
        }

        $exam = Exam::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'duration' => $request->input('duration'),
            'type' => $request->input('type'),
            'teacher_id' => auth()->id,
            'is_online' => true,
        ]);

        return response()->json(['message' => 'Exam published successfully']);
    }

    public function getExamQuestions(Request $request, Exam $exam)
    {
        $questions = ExamHelper::getExamQuestions($exam);

        return response()->json($questions);
    }

    public function submitExamAnswers(Request $request, Exam $exam)
    {
        $student = Student::find()->id();

        if (!$exam->forStudent($student->id)->exists()) {
            return response()->json(['message' => 'You are not enrolled in this exam'], 403);
        }

        $submission = Submission::create([
            'exam_id' => $exam->id,
            'student_id' => $student->id,
        ]);

        foreach ($request->input('answers') as $answer) {
            $question = Question::find($answer['question_id']);

            $option = Option::find($answer['option_id']);

            $submission->answers()->create([
                'question_id' => $question->id,
                'option_id' => $option->id,
            ]);
        }

        return response()->json(['message' => 'Exam answers submitted successfully']);
    }

    public function getExamResults(Request $request, Exam $exam)
    {
        $student = Student::find()->id();

        $results = ExamHelper::getExamResults($exam, $student->id);

        return response()->json($results);
    }
}
