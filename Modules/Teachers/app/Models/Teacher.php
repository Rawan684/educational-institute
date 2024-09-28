<?php

namespace Modules\Teachers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Classes\Models\Grade;
use Modules\Classes\Models\Resource;
use Modules\Classes\Models\Subject;
// use Modules\Teachers\Database\Factories\TeacherFactory;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'email', 'password', 'phone_number', 'address'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }
    public function resources()
    {
        return $this->belongsToMany(Resource::class)
            ->withPivot('subject_id')
            ->wherePivot('subject_id', '=', 'subjects.id')
            ->unique('resource_id');
    }

    // protected static function newFactory(): TeacherFactory
    // {
    //     // return TeacherFactory::new();
    // }
}
