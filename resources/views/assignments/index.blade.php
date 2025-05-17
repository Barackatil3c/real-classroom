<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Assignments') }}
            </h2>
            @if(auth()->user()->isTeacher())
                <a href="{{ route('teacher.assignments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create Assignment') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($assignments->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">
                            {{ __('No assignments found.') }}
                        </p>
                    @else
                        <x-table :error="$errors->any() ? 'Please fix the errors below.' : null">
                            <x-slot name="header">
                                <x-table.header>{{ __('Title') }}</x-table.header>
                                <x-table.header>{{ __('Teacher') }}</x-table.header>
                                <x-table.header>{{ __('Due Date') }}</x-table.header>
                                <x-table.header align="right">{{ __('Actions') }}</x-table.header>
                            </x-slot>

                            @foreach($assignments as $assignment)
                                <x-table.row :error="$errors->has('assignment.' . $assignment->id)">
                                    <x-table.cell>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $assignment->title }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $assignment->teacher->name }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $assignment->due_date->format('M d, Y') }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell align="right">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if(auth()->user()->isTeacher())
                                                <a href="{{ route('teacher.assignments.show', $assignment) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                                    {{ __('View') }}
                                                </a>
                                                @if(auth()->user()->id === $assignment->teacher_id)
                                                    <a href="{{ route('teacher.assignments.edit', $assignment) }}" 
                                                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-indigo-200 dark:bg-indigo-900 dark:hover:bg-indigo-800">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('teacher.assignments.destroy', $assignment) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:text-red-200 dark:bg-red-900 dark:hover:bg-red-800"
                                                                onclick="return confirm('{{ __('Are you sure you want to delete this assignment?') }}')">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('student.assignments.show', $assignment) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                                    {{ __('View') }}
                                                </a>
                                            @endif
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
</x-app-layout> 