<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Submit Assignment') }}: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $assignment->title }}</h3>
                        <p class="text-gray-600">{{ $assignment->description }}</p>
                        <p class="text-sm text-gray-500 mt-2">Due: {{ $assignment->due_date->format('M d, Y H:i') }}</p>
                    </div>

                    <form action="{{ route('student.assignments.submit.store', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="submission_text" :value="__('Your Submission')" />
                            <textarea id="submission_text" name="submission_text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="6" required>{{ old('submission_text') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('submission_text')" />
                        </div>

                        <div>
                            <x-input-label for="attachment" :value="__('Attachment (Optional)')" />
                            <input type="file" name="attachment" id="attachment" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                dark:file:bg-indigo-900 dark:file:text-indigo-300
                                hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Accepted file types: PDF, DOC, DOCX, TXT. Maximum size: 10MB.') }}
                            </p>
                            <x-input-error class="mt-2" :messages="$errors->get('attachment')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Submit Assignment') }}</x-primary-button>
                            <a href="{{ route('student.assignments.show', $assignment) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 