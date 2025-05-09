@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2
            border-amber-400
            text-sm font-medium leading-5 text-amber-500 dark:text-amber-700 hover:text-amber-300
            focus:outline-none focus:border-amber-700
            transition duration-150 ease-in-out'

            : 'inline-flex items-center px-1 pt-1 border-b-2
            border-transparent
            text-sm font-medium leading-5 text-gray-500 hover:text-gray-300
            hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300
            transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
