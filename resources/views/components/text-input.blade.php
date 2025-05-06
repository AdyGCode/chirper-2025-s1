@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'px-2 py-1 border-gray-300 focus:outline-indigo-500 focus:outline-2 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
