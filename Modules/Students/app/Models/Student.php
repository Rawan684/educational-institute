<?php

namespace Modules\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Exams\Models\Assignment;
use Modules\Exams\Models\Evaluation;
use Modules\Exams\Models\Exam;

// use Modules\Students\Database\Factories\StudentFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'email', 'password', 'address', 'gender'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendances()
    {
        return $this->hasManyThrough(Attendance::class, Enrollment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function getAverageGradeAttribute()
    {
        $evaluations = $this->evaluations;
        $totalGrade = 0;
        $totalCount = 0;

        foreach ($evaluations as $evaluation) {
            $totalGrade += $evaluation->grade;
            $totalCount++;
        }

        return $totalGrade / $totalCount;
    }
    // Get the number of assignments
    public function getAssignmentCountAttribute()
    {
        $assignments = $this->assignments;
        return $assignments->count();
    }

    // Get the number of exams
    public function getExamCountAttribute()
    {
        $exams = $this->exams;
        return $exams->count();
    }

    // Get the number of evaluations
    public function getEvaluationCountAttribute()
    {
        return $this->evaluations->count();
    }
    // protected static function newFactory(): StudentFactory
    // {
    //     // return StudentFactory::new();
    // }
}
