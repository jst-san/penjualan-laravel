@props(['href', 'active' => false])

<a
    href="{{ $href }}"
    @class([
        'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition',
        'bg-blue-50 text-blue-600' => $active,
        'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! $active,
    ])
    @if ($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
