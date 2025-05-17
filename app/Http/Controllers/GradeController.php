<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Assignment;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teacher')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isTeacher()) {
            $grades = Grade::with(['student', 'assignment'])
                ->whereHas('assignment', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                })
                ->latest()
                ->paginate(10);
        } else {
            $grades = Grade::with('assignment')
                ->where('student_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Assignment $assignment)
    {
        $this->authorize('create', [Grade::class, $assignment]);
        
        // Get all students who have submitted the assignment
        $students = $assignment->submissions()
            ->with('student')
            ->get()
            ->pluck('student')
            ->unique('id');

        return view('grades.create', compact('assignment', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Assignment $assignment)
    {
        $this->authorize('create', [Grade::class, $assignment]);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $grade = $assignment->grades()->create($validated);

        return redirect()
            ->route('teacher.assignments.show', $assignment)
            ->with('success', 'Grade submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        $this->authorize('view', $grade);
        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        $this->authorize('update', $grade);
        return view('grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $this->authorize('update', $grade);

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $grade->update($validated);

        return redirect()
            ->route('teacher.assignments.show', $grade->assignment)
            ->with('success', 'Grade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);
        
        $assignment = $grade->assignment;
        $grade->delete();

        return redirect()
            ->route('teacher.assignments.show', $assignment)
            ->with('success', 'Grade deleted successfully.');
    }
}
