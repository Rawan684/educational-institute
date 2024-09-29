<?php

namespace Modules\Exams\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Exams\Models\Assignment;
use Modules\Students\Models\Student;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignment::with('teacher', 'students')->get();
        return response()->json($assignments);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|file',
            'teacher_id' => 'required|integer',
            'student_ids' => 'required|array',
        ]);

        $assignment = new Assignment();
        $assignment->title = $request->input('title');
        $assignment->description = $request->input('description');
        $assignment->teacher_id = $request->input('teacher_id');
        $assignment->file = $request->file('file')->store('assignments');

        if ($assignment->save()) {
            $assignment->students()->attach($request->input('student_ids'));
            return response()->json($assignment, 201);
        } else {
            return response()->json(['error' => 'Failed to create assignment!'], 500);
        }
    }
    public function show($id)
    {
        $assignment = Assignment::with('teacher', 'students')->find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Assignment not found!'], 404);
        }
        return response()->json($assignment);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'teacher_id' => 'required|integer',
            'student_ids' => 'required|array',
        ]);

        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Assignment not found!'], 404);
        }

        $assignment->title = $request->input('title');
        $assignment->description = $request->input('description');
        $assignment->teacher_id = $request->input('teacher_id');

        if ($request->hasFile('file')) {
            Storage::delete($assignment->file);
            $assignment->file = $request->file('file')->store('assignments');
        }

        if ($assignment->save()) {
            $assignment->students()->sync($request->input('student_ids'));
            return response()->json($assignment);
        } else {
            return response()->json(['error' => 'Failed to update assignment!'], 500);
        }
    }
    public function destroy($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Assignment not found!'], 404);
        }

        Storage::delete($assignment->file);
        $assignment->delete();
        return response()->json(['message' => 'Assignment deleted successfully!']);
    }
    public function download($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Assignment not found!'], 404);
        }

        $file = Storage::disk('public')->get($assignment->file);
        return response()->download($file, $assignment->title . '.pdf');
    }

    /**
     * Upload the assignment file by a student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Assignment not found!'], 404);
        }

        $student = Student::find($request->input('student_id'));
        if (!$student) {
            return response()->json(['error' => 'Student not found!'], 404);
        }

        if ($assignment->students()->where('student_id', $student->id)->exists()) {
            return response()->json(['error' => 'Student has already uploaded the assignment!'], 400);
        }

        $file = $request->file('file');
        $filename = $student->name . '_' . $assignment->title . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads', $filename);

        $assignment->students()->attach($student->id, ['file' => $filename]);
        return response()->json(['message' => 'Assignment uploaded successfully!']);
    }
}
