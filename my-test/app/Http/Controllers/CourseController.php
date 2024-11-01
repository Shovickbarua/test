<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
   
    public function index()
    {
        return view('courses.index'); // Load the index view
    }

    public function allCourses()
    {
        return response()->json(Course::all()); // Return all courses as JSON
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'duration' => 'required|integer|min:1',
        ]);

        Course::create($request->all());
        return response()->json(['success' => 'Course added successfully.']);
    }

    public function show(Course $course)
    {
        return response()->json($course); // Return course as JSON
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'duration' => 'required|integer|min:1',
        ]);

        $course->update($request->all());
        return response()->json(['success' => 'Course updated successfully.']);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['success' => 'Course deleted successfully.']);
    }
}
