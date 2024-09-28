<?php

namespace Modules\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Students\Database\Factories\AttendanceFactory;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'enrollment_id',
        'date',
        'status'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function scopeForEnrollmentBetweenDates($query, $enrollmentId, $startDate, $endDate)
    {
        return $query->where('enrollment_id', $enrollmentId)
            ->whereBetween('attendance5656', [$startDate, $endDate]);
    }

    public function scopeForEnrollmentInDate($query, $enrollmentId, $attendanceDate)
    {
        return $query->where('enrollment_id', $enrollmentId)
            ->where('attendance_date', $attendanceDate);
    }
    // protected static function newFactory(): AttendanceFactory
    // {
    //     // return AttendanceFactory::new();
    // }
}
