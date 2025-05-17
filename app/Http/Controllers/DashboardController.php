<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isTeacher()) {
            return $this->teacherDashboard();
        }
        
        return $this->studentDashboard();
    }

    protected function teacherDashboard()
    {
        $assignments = Assignment::where('teacher_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::where('teacher_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $recentGrades = Grade::with(['assignment', 'student'])
            ->whereHas('assignment', function ($query) {
                $query->where('teacher_id', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.teacher', compact('assignments', 'announcements', 'recentGrades'));
    }

    protected function studentDashboard()
    {
        $assignments = Assignment::latest()
            ->take(5)
            ->get();

        $grades = Grade::where('student_id', auth()->id())
            ->with('assignment')
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::latest()
            ->take(5)
            ->get();

        return view('dashboard.student', compact('assignments', 'grades', 'announcements'));
    }
}
