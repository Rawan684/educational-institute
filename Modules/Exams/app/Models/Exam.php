<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Teachers\Models\Teacher;
use Modules\Students\Models\Student;
// use Modules\Exams\Database\Factories\ExamFactory;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'duration',
        'type', // e.g. written, practical, online
        'teacher_id',
        'is_online'
    ];


    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'exam_student');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_online', true);
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->whereHas('students', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        });
    }
    // protected static function newFactory(): ExamFactory
    // {
    //     // return ExamFactory::new();
    // }
}
