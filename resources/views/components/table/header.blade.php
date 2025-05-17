@props(['align' => 'left'])

<th {{ $attributes->merge(['class' => 'px-6 py-3 text-' . $align . ' text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider']) }}>
    {{ $slot }}
</th> 