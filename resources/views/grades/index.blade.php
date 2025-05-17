<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('My Grades') }}
        </h2>
    </x-slot>

    <div class="py-12" style="border-radius: 23px; background-color: #111827;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6" style="padding: 1.5rem; background-color: #1f2937; border-radius: 20px;">
                    @if($grades->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">
                            {{ __('No grades available yet.') }}
                        </p>
                    @else
                        <x-table :error="$errors->any() ? 'Please fix the errors below.' : null">
                            <x-slot name="header">
                                <x-table.header class="text-gray-900 dark:text-gray-100">{{ __('Assignment') }}</x-table.header>
                                <x-table.header class="text-gray-900 dark:text-gray-100">{{ __('Teacher') }}</x-table.header>
                                <x-table.header class="text-gray-900 dark:text-gray-100">{{ __('Score') }}</x-table.header>
                                <x-table.header class="text-gray-900 dark:text-gray-100">{{ __('Feedback') }}</x-table.header>
                                <x-table.header class="text-gray-900 dark:text-gray-100">{{ __('Graded On') }}</x-table.header>
                            </x-slot>

                            @foreach($grades as $grade)
                                <x-table.row :error="$errors->has('grade.' . $grade->id)" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <x-table.cell>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $grade->assignment->title }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Due: {{ $grade->assignment->due_date->format('M d, Y') }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $grade->assignment->teacher->name }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $grade->score }}
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $grade->feedback ?: 'No feedback provided' }}
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

                        <div class="mt-6">
                            {{ $grades->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 