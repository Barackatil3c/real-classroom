<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Teacher Routes
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // Assignment Routes
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::get('assignments/{assignment}/download/{submission}', [AssignmentController::class, 'downloadAttachment'])->name('assignments.download');

    // Announcement Routes
    Route::resource('announcements', AnnouncementController::class);

    // Grade Routes
    Route::get('assignments/{assignment}/grades/create', [GradeController::class, 'create'])->name('grades.create');
    Route::post('assignments/{assignment}/grades', [GradeController::class, 'store'])->name('grades.store');
    Route::get('assignments/{assignment}/grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
    Route::put('assignments/{assignment}/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
});

// Student Routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    // Assignment Routes
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('assignments/{assignment}/submit', [AssignmentController::class, 'submitForm'])->name('assignments.submit');
    Route::post('assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit.store');
    Route::get('assignments/{assignment}/download/{submission}', [AssignmentController::class, 'downloadAttachment'])->name('assignments.download');

    // Grade Routes
    Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
    Route::get('grades/{grade}', [GradeController::class, 'show'])->name('grades.show');

    // Announcement Routes
    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
});

Route::post('/theme/switch', [ThemeController::class, 'switch'])->name('theme.switch');

require __DIR__.'/auth.php';
