<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Announcements') }}
            </h2>
            @if(auth()->user()->isTeacher())
                <a href="{{ route('teacher.announcements.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('New Announcement') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12" style="border-radius: 23px; background-color: #111827;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                    @if($announcements->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">
                            {{ __('No announcements available.') }}
                        </p>
                    @else
                        <x-table :error="$errors->any() ? 'Please fix the errors below.' : null">
                            <x-slot name="header">
                                <x-table.header>{{ __('Title') }}</x-table.header>
                                <x-table.header>{{ __('Teacher') }}</x-table.header>
                                <x-table.header>{{ __('Posted On') }}</x-table.header>
                                <x-table.header align="right">{{ __('Actions') }}</x-table.header>
                            </x-slot>

                            @foreach($announcements as $announcement)
                                <x-table.row :error="$errors->has('announcement.' . $announcement->id)">
                                    <x-table.cell>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $announcement->title }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($announcement->content, 100) }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $announcement->teacher->name }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $announcement->created_at->format('M d, Y') }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell align="right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('teacher.announcements.show', $announcement) }}" 
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                                {{ __('View') }}
                                            </a>
                                            @if(auth()->user()->isTeacher() && auth()->id() === $announcement->teacher_id)
                                                <a href="{{ route('teacher.announcements.edit', $announcement) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">
                                                    {{ __('Edit') }}
                                                </a>
                                                <form method="POST" action="{{ route('teacher.announcements.destroy', $announcement) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600"
                                                        onclick="return confirm('{{ __('Are you sure you want to delete this announcement?') }}')">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        </x-table>

                        <div class="mt-6">
                            {{ $announcements->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 