<?php

namespace Modules\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    // protected static function newFactory(): StudentFactory
    // {
    //     // return StudentFactory::new();
    // }
}
