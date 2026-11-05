@props([
    'type' => 'info',
    'message' => null,
    'dismissible' => true,
])

@php
    $typeClasses = [
        'success' => [
            'wrapper' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
            'icon' => 'text-emerald-500',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        ],
        'danger' => [
            'wrapper' => 'bg-rose-50 border-rose-200 text-rose-800',
            'icon' => 'text-rose-500',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        ],
        'error' => [
            'wrapper' => 'bg-rose-50 border-rose-200 text-rose-800',
            'icon' => 'text-rose-500',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        ],
        'warning' => [
            'wrapper' => 'bg-amber-50 border-amber-200 text-amber-800',
            'icon' => 'text-amber-500',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
        ],
        'info' => [
            'wrapper' => 'bg-blue-50 border-blue-200 text-blue-800',
            'icon' => 'text-blue-500',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        ],
    ];

    $current = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<div x-data="{ show: true }" x-show="show" class="flex items-start gap-3 p-3.5 mb-6 border rounded-xl shadow-xs transition-all {{ $current['wrapper'] }}" role="alert">
    <div class="flex-shrink-0 mt-0.5 {{ $current['icon'] }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $current['svg'] !!}
        </svg>
    </div>
    <div class="flex-1 text-xs font-medium leading-relaxed">
        {{ $message ?? $slot }}
    </div>
    @if ($dismissible)
        <button type="button" @click="show = false" class="flex-shrink-0 ml-auto -mx-1 -my-1 rounded p-1 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors" aria-label="Close">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
