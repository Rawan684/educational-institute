<?php

namespace Modules\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Classes\Models\Grade;
use Modules\Classes\Models\Course;
use Modules\Classes\Models\Subject;
// use Modules\Students\Database\Factories\EnrollmentFactory;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'grade_id',
        'subject_id',
        'course_id',
        'payment_status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // protected static function newFactory(): EnrollmentFactory
    // {
    //     // return EnrollmentFactory::new();
    // }
}
