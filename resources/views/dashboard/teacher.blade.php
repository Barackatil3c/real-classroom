<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" style="border-radius: 23px; background-color: #111827;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Assignments -->
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Assignments</h3>
                            <a href="{{ route('teacher.assignments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Assignment
                            </a>
                        </div>
                        @if($assignments->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No assignments created yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($assignments as $assignment)
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $assignment->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Due: {{ $assignment->due_date->format('M d, Y') }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('teacher.assignments.show', $assignment) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Announcements</h3>
                            <a href="{{ route('teacher.announcements.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Announcement
                            </a>
                        </div>
                        @if($announcements->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No announcements posted yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($announcements as $announcement)
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $announcement->title }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($announcement->content, 100) }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('teacher.announcements.show', $announcement) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Grades -->
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                    <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Grades</h3>
                        @if($recentGrades->isEmpty())
                            <p class="text-center text-gray-500 dark:text-gray-400">No grades submitted yet.</p>
                        @else
                            <x-table :error="$errors->any() ? 'Please fix the errors below.' : null">
                                <x-slot name="header">
                                    <x-table.header>{{ __('Student') }}</x-table.header>
                                    <x-table.header>{{ __('Assignment') }}</x-table.header>
                                    <x-table.header>{{ __('Score') }}</x-table.header>
                                    <x-table.header>{{ __('Date') }}</x-table.header>
                                </x-slot>

                                @foreach($recentGrades as $grade)
                                    <x-table.row :error="$errors->has('grade.' . $grade->id)">
                                        <x-table.cell>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $grade->student->name }}
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $grade->assignment->title }}
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $grade->score }}
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $grade->created_at->format('M d, Y') }}
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforeach
                            </x-table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 