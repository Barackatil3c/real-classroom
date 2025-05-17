<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Announcement Details') }}
            </h2>
            @if(auth()->user()->isTeacher())
                <div class="flex space-x-2">
                    <a href="{{ route('teacher.announcements.edit', $announcement) }}" 
                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('teacher.announcements.destroy', $announcement) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:text-red-200 dark:bg-red-900 dark:hover:bg-red-800"
                                onclick="return confirm('{{ __('Are you sure you want to delete this announcement?') }}')">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12" style="border-radius: 23px; background-color: #111827;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #1f2937; border-radius: 20px;">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $announcement->title }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Posted by') }} {{ $announcement->teacher->name }} {{ __('on') }} {{ $announcement->created_at->format('F j, Y g:i A') }}
                        </p>
                    </div>

                    <div class="prose dark:prose-invert max-w-none">
                        {{ $announcement->content }}
                    </div>

                    <div class="mt-6">
                        <a href="{{ auth()->user()->isTeacher() ? route('teacher.announcements.index') : route('student.announcements.index') }}" 
                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:text-red-200 dark:bg-red-900 dark:hover:bg-red-800">
                            {{ __('Back to Announcements') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 