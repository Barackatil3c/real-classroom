<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'teacher_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function isSubmittedBy(User $student)
    {
        return $this->submissions()->where('student_id', $student->id)->exists();
    }

    public function getSubmissionBy(User $student)
    {
        return $this->submissions()->where('student_id', $student->id)->first();
    }

    public function isPastDue()
    {
        return now()->isAfter($this->due_date);
    }
}
