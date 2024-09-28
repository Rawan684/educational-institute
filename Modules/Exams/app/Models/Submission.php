<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Students\Models\Student;
// use Modules\Exams\Database\Factories\SubmissionFactory;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'submission_text',
        'marks'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    // protected static function newFactory(): SubmissionFactory
    // {
    //     // return SubmissionFactory::new();
    // }
}
