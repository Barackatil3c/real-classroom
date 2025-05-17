<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teacher')->except(['index', 'show', 'submitForm', 'submit', 'downloadAttachment']);
    }

    /**
     * Display a listing of assignments.
     */
    public function index()
    {
        $assignments = Assignment::with('teacher')
            ->when(auth()->user()->isStudent(), function ($query) {
                return $query->where('due_date', '>=', now());
            })
            ->latest()
            ->paginate(10);

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create()
    {
        return view('assignments.create');
    }

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:now',
        ]);

        $assignment = auth()->user()->assignments()->create($validated);

        return redirect()
            ->route('teacher.assignments.show', $assignment)
            ->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified assignment.
     */
    public function show(Assignment $assignment)
    {
        if (auth()->user()->isTeacher()) {
            $assignment->load(['teacher', 'submissions.student']);
            return view('assignments.show', [
                'assignment' => $assignment,
                'submissions' => $assignment->submissions
            ]);
        } else {
            $assignment->load(['teacher']);
            $submission = $assignment->submissions()
                ->where('student_id', auth()->id())
                ->first();
            return view('assignments.show', [
                'assignment' => $assignment,
                'submission' => $submission
            ]);
        }
    }

    /**
     * Show the form for editing the specified assignment.
     */
    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        return view('assignments.edit', compact('assignment'));
    }

    /**
     * Update the specified assignment in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:now',
        ]);

        $assignment->update($validated);

        return redirect()
            ->route('teacher.assignments.show', $assignment)
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified assignment from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);

        // Delete all submissions and their attachments
        foreach ($assignment->submissions as $submission) {
            if ($submission->attachment_path) {
                Storage::delete($submission->attachment_path);
            }
            $submission->delete();
        }

        $assignment->delete();

        return redirect()
            ->route('teacher.assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }

    /**
     * Show the form for submitting an assignment.
     */
    public function submitForm(Assignment $assignment)
    {
        if (!auth()->user()->isStudent()) {
            abort(403, 'Only students can submit assignments.');
        }

        if ($assignment->due_date < now()) {
            return redirect()
                ->route('student.assignments.show', $assignment)
                ->with('error', 'This assignment is past due date.');
        }

        return view('assignments.submit', compact('assignment'));
    }

    /**
     * Store a new submission for the assignment.
     */
    public function submit(Request $request, Assignment $assignment)
    {
        if ($assignment->due_date < now()) {
            return redirect()
                ->route('student.assignments.show', $assignment)
                ->with('error', 'This assignment is past due date.');
        }

        $validated = $request->validate([
            'submission_text' => 'required|string',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt',
        ]);

        $submission = new AssignmentSubmission([
            'submission_text' => $validated['submission_text'],
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('submissions');
            $submission->attachment_path = $path;
        }

        $submission->student()->associate(auth()->user());
        $submission->assignment()->associate($assignment);
        $submission->save();

        return redirect()
            ->route('student.assignments.show', $assignment)
            ->with('success', 'Assignment submitted successfully.');
    }

    /**
     * Download the attachment for a submission.
     */
    public function downloadAttachment(Assignment $assignment, AssignmentSubmission $submission)
    {
        if (!auth()->user()->isTeacher() && $submission->student_id !== auth()->id()) {
            abort(403);
        }

        if (!$submission->attachment_path) {
            abort(404);
        }

        return Storage::download($submission->attachment_path);
    }
}
