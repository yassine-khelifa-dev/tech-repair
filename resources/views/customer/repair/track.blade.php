<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Repair Ticket Tracking </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen antialiased bg-gray-900 dark:bg-gray-900">

    <div class="container mx-auto px-4 py-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    Repair Ticket Tracking
                </h1>
                <p class="text-gray-400">

                    Ticket #{{ $repair_ticket?->ticket_number }}
                </p>
            </div>
            @auth
                <a href="{{ route('repair-tickets.index') }}"
                    class="px-4 py-2 rounded bg-blue-500 hover:bg-red-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                </a>
            @endauth


            @php use Illuminate\Support\Facades\URL;  @endphp
            <a href="{{ URL::temporarySignedRoute('repair-tickets.download', now()->addMinutes(10), [
                'repair_ticket' => $repair_ticket->id,
            ]) }}"
                class="px-4 py-2 rounded bg-green-700 hover:bg-red-600 text-white">

                Download Ticket receipt
            </a>



        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Customer Information --}}
            @include('repair.partials._customer-info')

            {{-- Device Information --}}
            @include('repair.partials._device-info')

            {{-- Repair Details --}}
            @include('repair.partials._repair-details')
        </div>
    </div>
</body>

</html>
