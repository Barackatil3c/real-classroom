@props(['align' => 'left', 'error' => false])

<td {{ $attributes->merge(['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-' . $align . ' ' . ($error ? 'bg-red-50 dark:bg-red-900/20' : '')]) }}>
    {{ $slot }}
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</td> 