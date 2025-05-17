<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $assignment->title }}
            </h2>
            @if(auth()->user()->isTeacher())
                <div class="flex space-x-4">
                    <a href="{{ route('teacher.assignments.edit', $assignment) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Edit Assignment') }}
                    </a>
                    <form action="{{ route('teacher.assignments.destroy', $assignment) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('{{ __('Are you sure you want to delete this assignment?') }}')">
                            {{ __('Delete Assignment') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Assignment Details') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $assignment->description }}</p>
                        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                            <p>{{ __('Created by') }}: {{ $assignment->teacher->name }}</p>
                            <p>{{ __('Due Date') }}: {{ $assignment->due_date->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    @if(auth()->user()->isStudent())
                        @if(!$submission)
                            @if(!$assignment->isPastDue())
                                <div class="mt-6">
                                    <a href="{{ route('student.assignments.submit', $assignment) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Submit Assignment') }}
                                    </a>
                                </div>
                            @else
                                <div class="mt-6 text-red-600 dark:text-red-400">
                                    {{ __('This assignment is past due and cannot be submitted.') }}
                                </div>
                            @endif
                        @else
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Your Submission') }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ $submission->submission_text }}</p>
                                @if($submission->attachment_path)
                                    <div class="mt-4">
                                        <a href="{{ route('student.assignments.download', ['assignment' => $assignment, 'submission' => $submission]) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            {{ __('Download Attachment') }}
                                        </a>
                                    </div>
                                @endif
                                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Submitted at') }}: {{ $submission->submitted_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">{{ __('Submissions') }}</h3>
                            @if($submissions->isEmpty())
                                <p class="text-gray-500 dark:text-gray-400">{{ __('No submissions yet.') }}</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('Student') }}
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('Submitted At') }}
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('Actions') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($submissions as $submission)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $submission->student->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $submission->submitted_at->format('M d, Y H:i') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        @php
                                                            $grade = $submission->student->grades()
                                                                ->where('assignment_id', $assignment->id)
                                                                ->first();
                                                        @endphp
                                                        @if(!$grade)
                                                            <a href="{{ route('teacher.grades.create', ['assignment' => $assignment, 'student' => $submission->student]) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                                {{ __('Grade') }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('teacher.grades.edit', ['assignment' => $assignment, 'grade' => $grade]) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                                {{ __('Edit Grade') }}
                                                            </a>
                                                        @endif
                                                        @if($submission->attachment_path)
                                                            <a href="{{ route('teacher.assignments.download', ['assignment' => $assignment, 'submission' => $submission]) }}" class="ml-3 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                                {{ __('Download') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 