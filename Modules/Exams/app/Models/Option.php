<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Exams\Database\Factories\OptionFactory;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // protected static function newFactory(): OptionFactory
    // {
    //     // return OptionFactory::new();
    // }
}
