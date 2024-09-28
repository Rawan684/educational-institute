<?php

namespace Modules\Exams\Helpers;

use Modules\Exams\Models\Exam;

class ExamHelper
{
    public function handle()
    {
        //
    }

    public static function getExamQuestions(Exam $exam)
    {
        return $exam->questions()->with('options')->get();
    }

    public static function getExamResults(Exam $exam, $student)
    {
        $submission = $student->submissions()->where('exam_id', $exam->id)->first();

        $answers = $submission->answers()->with('question', 'option')->get();
    }
}
