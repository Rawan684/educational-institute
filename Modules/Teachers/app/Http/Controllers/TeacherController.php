<?php

namespace Modules\Teachers\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Teachers\Models\Teacher;
use Modules\Classes\Models\Subject;
use Modules\Classes\Models\Resource;

class TeacherController extends Controller
{
    public function addResourceToSubject(Request $request, Teacher $teacher, Subject $subject)
    {
        // Validate the request
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
        ]);

        // Get the resource instance
        $resource = Resource::find($request->input('resource_id'));

        // Check if the resource is already associated with another teacher and subject
        if ($resource->teachers()->exists()) {
            return response()->json(['message' => 'Resource is already associated with another teacher and subject'], 422);
        }

        // Add the resource to the teacher's subjects
        $teacher->resources()->attach($resource->id, ['subject_id' => $subject->id]);

        return response()->json(['message' => 'Resource added to subject successfully']);
    }
    public function updateResource(Request $request, Teacher $teacher, Subject $subject, Resource $resource)
    {
        // Validate the request
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
        ]);

        // Check if the teacher owns the resource
        if (!$teacher->resources()->where('resource_id', $resource->id)->exists()) {
            return response()->json(['message' => 'Teacher does not own this resource'], 422);
        }

        // Update the resource
        $resource->update($request->all());

        return response()->json(['message' => 'Resource updated successfully']);
    }

    public function deleteResource(Teacher $teacher, Subject $subject, Resource $resource)
    {
        // Check if the teacher owns the resource
        if (!$teacher->resources()->where('resource_id', $resource->id)->exists()) {
            return response()->json(['message' => 'Teacher does not own this resource'], 422);
        }

        // Delete the resource
        $resource->delete();

        return response()->json(['message' => 'Resource deleted successfully']);
    }
}
