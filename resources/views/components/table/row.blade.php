@props(['striped' => true, 'error' => false])

<tr {{ $attributes->merge(['class' => 'hover:bg-gray-50 dark:hover:bg-gray-800 ' . ($error ? 'bg-red-50 dark:bg-red-900/20' : '')]) }}>
    {{ $slot }}
</tr> 