<?php

namespace Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Classes\Database\Factories\SubjectFactory;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'description'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    // protected static function newFactory(): SubjectFactory
    // {
    //     // return SubjectFactory::new();
    // }
}
