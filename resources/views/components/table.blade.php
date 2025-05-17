@props(['striped' => true, 'error' => false])

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200 dark:divide-gray-700 ' . ($error ? 'border-2 border-red-500 dark:border-red-400' : '')]) }}>
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                {{ $header }}
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </tbody>
    </table>
    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div> 