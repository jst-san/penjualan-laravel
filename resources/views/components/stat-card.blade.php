@props(['label', 'value', 'accent' => 'blue', 'footer' => null])

@php
    $accents = [
        'blue' => 'bg-blue-50 text-blue-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'violet' => 'bg-violet-50 text-violet-600',
    ];
@endphp

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-center justify-between gap-3">
        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
        <span class="flex h-10 w-10 items-center justify-center rounded-lg {{ $accents[$accent] ?? $accents['blue'] }}">
            {{ $slot }}
        </span>
    </div>
    <p class="mt-3 text-2xl font-bold text-slate-900">{{ $value }}</p>
    @if ($footer)
        <p class="mt-1 text-xs text-slate-400">{{ $footer }}</p>
    @endif
</div>
