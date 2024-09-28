<?php

namespace Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Classes\Database\Factories\GradeFactory;

class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'level', 'description'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, Subject::class);
    }

    public function resources()
    {
        return $this->hasManyThrough(Resource::class, Subject::class);
    }

    // protected static function newFactory(): GradeFactory
    // {
    //     // return GradeFactory::new();
    // }
}
