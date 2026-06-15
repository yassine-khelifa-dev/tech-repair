@props(['status'])

@php

    $config = match ($status) {
        // Repair Request
        'pending' => [
            'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            'label' => 'Pending',
            'icon' => 'clock',
        ],

        'approved' => [
            'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'label' => 'Approved',
            'icon' => 'check',
        ],

        'rejected' => [
            'class' => 'bg-red-500/10 text-red-400 border-red-500/20',
            'label' => 'Rejected',
            'icon' => 'x',
        ],
        // Repair Ticket
        'received' => [
            'class' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
            'label' => 'Received',
            'icon' => 'clock',
        ],

        'diagnosis' => [
            'class' => 'bg-violet-500/10 text-violet-400 border-violet-500/20',
            'label' => 'Diagnosis',
            'icon' => 'search',
        ],

        'waiting_parts' => [
            'class' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
            'label' => 'Waiting Parts',
            'icon' => 'clock',
        ],

        'in_progress' => [
            'class' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'label' => 'In Progress',
            'icon' => 'settings',
        ],

        'ready' => [
            'class' => 'bg-green-500/10 text-green-400 border-green-500/20',
            'label' => 'Ready',
            'icon' => 'check',
        ],

        'delivered' => [
            'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'label' => 'Delivered',
            'icon' => 'check',
        ],

        'cancelled' => [
            'class' => 'bg-red-500/10 text-red-400 border-red-500/20',
            'label' => 'Cancelled',
            'icon' => 'x',
        ],
        'waiting_device' => [
            'class' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
            'label' => 'Waiting Device',
            'icon' => 'device',
        ],

        default => [
            'class' => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
            'label' => ucfirst($status),
            'icon' => 'clock',
        ],
    };

@endphp

<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full border font-medium text-sm {{ $config['class'] }}">

    @if ($config['icon'] === 'clock')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @endif

    @if ($config['icon'] === 'device')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
        </svg>
    @endif

    @if ($config['icon'] === 'check')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
    @endif

    @if ($config['icon'] === 'x')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    @endif

    @if ($config['icon'] === 'search')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35" />
            <circle cx="11" cy="11" r="6" />
        </svg>
    @endif

    @if ($config['icon'] === 'settings')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.325 4.317a1.724 1.724 0 013.35 0l.172.696a1.724 1.724 0 002.573 1.066l.61-.356a1.724 1.724 0 012.356.633l.356.61a1.724 1.724 0 01-1.066 2.573l-.696.172a1.724 1.724 0 000 3.35l.696.172a1.724 1.724 0 011.066 2.573l-.356.61a1.724 1.724 0 01-2.356.633l-.61-.356a1.724 1.724 0 00-2.573 1.066l-.172.696a1.724 1.724 0 01-3.35 0l-.172-.696a1.724 1.724 0 00-2.573-1.066l-.61.356a1.724 1.724 0 01-2.356-.633l-.356-.61a1.724 1.724 0 011.066-2.573l.696-.172a1.724 1.724 0 000-3.35l-.696-.172a1.724 1.724 0 01-1.066-2.573l.356-.61a1.724 1.724 0 012.356-.633l.61.356a1.724 1.724 0 002.573-1.066l.172-.696z" />
        </svg>
    @endif

    {{ $config['label'] }}

</span>
