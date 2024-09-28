<?php

namespace Modules\Classes\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Classes\Models\Grade as ClassModel;
use Modules\Classes\Models\Subject;
use Modules\Classes\Models\Course;


//controller to add classes, subjects, and courses
class GradeController extends Controller
{

    public function index()
    {
        $classes = ClassModel::with('subjects', 'subjects.courses')->get();
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $class = ClassModel::create($request->all());

        if ($request->has('subjects')) {
            foreach ($request->input('subjects') as $subjectData) {
                $subject = $class->subjects()->create($subjectData);

                if (isset($subjectData['courses'])) {
                    foreach ($subjectData['courses'] as $courseData) {
                        $subject->courses()->create($courseData);
                    }
                }
            }
        }

        return response()->json($class, 201);
    }

    public function show($id)
    {
        $class = ClassModel::with('subjects', 'subjects.courses')->find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        return response()->json($class);
    }

    public function update(Request $request, $id)
    {
        $class = ClassModel::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->update($request->all());

        if ($request->has('subjects')) {
            foreach ($request->input('subjects') as $subjectData) {
                $subject = $class->subjects()->updateOrCreate(['id' => $subjectData['id']], $subjectData);

                if (isset($subjectData['courses'])) {
                    foreach ($subjectData['courses'] as $courseData) {
                        $subject->courses()->updateOrCreate(['id' => $courseData['id']], $courseData);
                    }
                }
            }
        }

        return response()->json($class);
    }

    public function destroy($id)
    {
        $class = ClassModel::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        $class->delete();
        return response()->json(['message' => 'Class deleted']);
    }
}
