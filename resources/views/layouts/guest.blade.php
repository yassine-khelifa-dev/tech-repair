<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tech Repair') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes repair-phone-float {
                0%, 100% { transform: translateY(0) rotate(-2deg); }
                50% { transform: translateY(-14px) rotate(2deg); }
            }

            @keyframes repair-tool-pulse {
                0%, 100% { transform: scale(1); opacity: .72; }
                50% { transform: scale(1.08); opacity: 1; }
            }

            @keyframes repair-scan-line {
                0% { transform: translateY(18px); opacity: 0; }
                18%, 76% { opacity: 1; }
                100% { transform: translateY(172px); opacity: 0; }
            }

            .repair-phone {
                animation: repair-phone-float 6s ease-in-out infinite;
                transform-origin: center;
            }

            .repair-tool {
                animation: repair-tool-pulse 2.5s ease-in-out infinite;
                transform-origin: center;
            }

            .repair-scan {
                animation: repair-scan-line 3.4s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen overflow-hidden bg-gray-950 text-white">
            <div class="mx-auto grid min-h-screen max-w-7xl items-center gap-10 px-6 py-8 lg:grid-cols-[1fr_460px] lg:px-8">
                <section class="hidden lg:block">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-md bg-cyan-400 text-gray-950 shadow-lg shadow-cyan-400/20">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8" />
                                <path d="M10 18h4M10 6h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <path d="m14.5 11.5 3.2-3.2 1.4 1.4-3.2 3.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text-xl font-extrabold tracking-normal text-white">Tech Repair</span>
                    </a>

                    <div class="mt-12 max-w-2xl">
                        <p class="text-sm font-bold uppercase tracking-wide text-cyan-300">Smartphone repair system</p>
                        <h1 class="mt-4 text-5xl font-extrabold leading-tight tracking-normal text-white">
                            Track repairs from request to delivery.
                        </h1>
                        <p class="mt-5 max-w-xl text-lg leading-8 text-gray-300">
                            Manage requests, tickets, customer updates, and repair progress from one focused workspace.
                        </p>
                    </div>

                    <div class="relative mt-8 flex max-w-xl items-center justify-center">
                        <div class="absolute inset-x-16 bottom-6 h-24 rounded-[50%] bg-cyan-400/10 blur-3xl"></div>

                        <svg class="relative h-auto w-full max-w-[440px]" viewBox="0 0 520 420" fill="none" role="img" aria-label="Animated smartphone repair illustration">
                            <g opacity=".35">
                                <path d="M92 352h336" stroke="#334155" stroke-width="2" stroke-linecap="round" />
                                <path d="M150 388h220" stroke="#1f2937" stroke-width="2" stroke-linecap="round" />
                            </g>

                            <g class="repair-phone">
                                <rect x="170" y="34" width="180" height="316" rx="34" fill="#020617" stroke="#67e8f9" stroke-width="3" />
                                <rect x="188" y="66" width="144" height="246" rx="20" fill="#111827" stroke="#1f2937" stroke-width="2" />
                                <path d="M235 50h50" stroke="#67e8f9" stroke-width="5" stroke-linecap="round" opacity=".9" />
                                <circle cx="260" cy="330" r="8" fill="#67e8f9" opacity=".8" />
                                <path d="M211 142h98M211 176h76M211 210h98" stroke="#334155" stroke-width="10" stroke-linecap="round" />
                                <path d="M222 264h76" stroke="#67e8f9" stroke-width="8" stroke-linecap="round" opacity=".9" />

                                <g class="repair-scan">
                                    <rect x="200" y="84" width="120" height="4" rx="2" fill="#22d3ee" />
                                    <rect x="200" y="88" width="120" height="30" fill="url(#repairScanGlow)" />
                                </g>

                                <g transform="translate(230 112)">
                                    <rect x="0" y="0" width="60" height="60" rx="14" fill="#0f172a" stroke="#475569" stroke-width="2" />
                                    <path d="m21 37 18-18M24 18h16v16" stroke="#67e8f9" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </g>

                            <g class="repair-tool" transform="translate(332 102) rotate(18)">
                                <path d="M34 12 84 62" stroke="#f8fafc" stroke-width="13" stroke-linecap="round" />
                                <path d="M22 0 47 25" stroke="#94a3b8" stroke-width="17" stroke-linecap="round" />
                                <path d="M72 52 98 78" stroke="#22d3ee" stroke-width="17" stroke-linecap="round" />
                            </g>

                            <g class="repair-tool" transform="translate(120 244) rotate(-24)" style="animation-delay: .8s;">
                                <path d="M21 78 76 23" stroke="#f8fafc" stroke-width="12" stroke-linecap="round" />
                                <path d="M65 11c13-10 29-10 41 0L88 30 77 19 95 1C84-4 73-1 65 11Z" fill="#22d3ee" />
                            </g>

                            <g transform="translate(352 256)">
                                <circle cx="18" cy="18" r="7" fill="#67e8f9" opacity=".9" />
                                <circle cx="52" cy="44" r="5" fill="#f8fafc" opacity=".75" />
                                <circle cx="24" cy="74" r="4" fill="#22d3ee" opacity=".9" />
                            </g>

                            <defs>
                                <linearGradient id="repairScanGlow" x1="260" x2="260" y1="88" y2="118" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#22d3ee" stop-opacity=".35" />
                                    <stop offset="1" stop-color="#22d3ee" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </section>

                <main class="mx-auto w-full max-w-md">
                    <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-md bg-cyan-400 text-gray-950 shadow-lg shadow-cyan-400/20">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8" />
                                    <path d="M10 18h4M10 6h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                    <path d="m14.5 11.5 3.2-3.2 1.4 1.4-3.2 3.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="text-xl font-extrabold tracking-normal text-white">Tech Repair</span>
                        </a>
                    </div>

                    <div class="rounded-lg border border-white/10 bg-white/[.04] p-6 shadow-2xl shadow-black/30 backdrop-blur sm:p-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
