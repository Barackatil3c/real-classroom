<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grade Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Assignment</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">{{ $grade->assignment->title }}</p>
                                <p class="text-sm text-gray-500">Due: {{ $grade->assignment->due_date->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Student</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">{{ $grade->student->name }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Score</h3>
                            <div class="mt-2">
                                <p class="text-2xl font-bold text-gray-900">{{ $grade->score }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Feedback</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">
                                    {{ $grade->feedback ?: 'No feedback provided' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Graded On</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">
                                    {{ $grade->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            @if(auth()->user()->isTeacher())
                                <a href="{{ route('grades.edit', $grade) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Edit Grade') }}
                                </a>
                            @endif
                            <a href="{{ auth()->user()->isTeacher() ? route('teacher.assignments.show', $grade->assignment) : route('student.assignments.show', $grade->assignment) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Back to Assignment') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 