<?php

namespace Modules\Students\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Students\Models\Attendance;
use Modules\Students\Models\Enrollment;

class AttendanceController extends Controller
{

    public function markAttendance(Request $request)
    {
        $enrollmentId = $request->input('enrollment_id');
        $attendanceDate = $request->input('attendance_date');
        $attendanceStatus = $request->input('attendance_status');

        $enrollment = Enrollment::find($enrollmentId);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $attendance = Attendance::ForEnrollmentInDate($enrollmentId, $attendanceDate)
            ->first();

        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->enrollment_id = $enrollmentId;
            $attendance->attendance_date = $attendanceDate;
        }

        $attendance->attendance_status = $attendanceStatus;
        $attendance->save();

        return response()->json(['message' => 'Attendance marked successfully']);
    }

    public function getAttendance(Request $request)
    {
        $enrollmentId = $request->input('enrollment_id');
        $attendanceDate = $request->input('attendance_date');

        $enrollment = Enrollment::find($enrollmentId);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $attendance = Attendance::ForEnrollmentInDate($enrollmentId, $attendanceDate)
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'Attendance not found'], 404);
        }

        return response()->json($attendance);
    }

    public function getAttendanceReport(Request $request)
    {
        $enrollmentId = $request->input('enrollment_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $enrollment = Enrollment::find($enrollmentId);
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        $attendances = Attendance::forEnrollmentBetweenDates($enrollmentId, $startDate, $endDate)
            ->get();

        return response()->json($attendances);
    }
}
