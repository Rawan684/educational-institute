<?php

namespace Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Classes\Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'description'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }
}
