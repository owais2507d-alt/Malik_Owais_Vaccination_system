@props(['href', 'active' => false])

@php
$classes = $active
    ? 'px-3 py-2 text-sm font-medium text-white bg-white/15 rounded-lg transition duration-150'
    : 'px-3 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition duration-150';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
