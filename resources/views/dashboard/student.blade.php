<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" style="border-radius: 23px; background-color: #111827;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Assignments -->
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Assignments</h3>
                        @if($assignments->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No assignments available.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($assignments as $assignment)
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $assignment->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Due: {{ $assignment->due_date->format('M d, Y') }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('student.assignments.show', $assignment) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Grades -->
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Grades</h3>
                        @if($grades->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No grades received yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($grades as $grade)
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $grade->assignment->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Score: {{ $grade->score }}</p>
                                        @if($grade->feedback)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Feedback: {{ $grade->feedback }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                    <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Announcements</h3>
                        @if($announcements->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No announcements available.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($announcements as $announcement)
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $announcement->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($announcement->content, 200) }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('student.announcements.show', $announcement) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Read More</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 