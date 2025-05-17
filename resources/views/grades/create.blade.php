<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Grade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $assignment->title }}</h3>
                        <p class="text-gray-600">{{ $assignment->description }}</p>
                    </div>

                    <form method="POST" action="{{ route('teacher.grades.store', $assignment) }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="student_id" :value="__('Student')" />
                            <select
                                id="student_id"
                                name="student_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Select a student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="score" :value="__('Score')" />
                            <input
                                type="number"
                                id="score"
                                name="score"
                                min="0"
                                max="100"
                                step="0.1"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                value="{{ old('score') }}"
                                required
                            >
                            <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="feedback" :value="__('Feedback (Optional)')" />
                            <textarea
                                id="feedback"
                                name="feedback"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="4"
                            >{{ old('feedback') }}</textarea>
                            <x-input-error :messages="$errors->get('feedback')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ auth()->user()->isTeacher() ? route('teacher.assignments.show', $assignment) : route('student.assignments.show', $assignment) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Save Grade') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 