<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Repair Flow') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes phone-float {
                0%, 100% { transform: translateY(0) rotate(-2deg); }
                50% { transform: translateY(-14px) rotate(2deg); }
            }

            @keyframes tool-pulse {
                0%, 100% { transform: scale(1); opacity: .72; }
                50% { transform: scale(1.08); opacity: 1; }
            }

            @keyframes scan-line {
                0% { transform: translateY(18px); opacity: 0; }
                18%, 76% { opacity: 1; }
                100% { transform: translateY(176px); opacity: 0; }
            }

            @keyframes spark {
                0%, 100% { transform: scale(.65); opacity: .25; }
                45% { transform: scale(1.1); opacity: 1; }
            }

            .repair-phone {
                animation: phone-float 6s ease-in-out infinite;
                transform-origin: center;
            }

            .repair-tool {
                animation: tool-pulse 2.4s ease-in-out infinite;
                transform-origin: center;
            }

            .repair-scan {
                animation: scan-line 3.4s ease-in-out infinite;
            }

            .repair-spark {
                animation: spark 1.8s ease-in-out infinite;
                transform-origin: center;
            }

            .repair-spark:nth-child(2) {
                animation-delay: .35s;
            }

            .repair-spark:nth-child(3) {
                animation-delay: .7s;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen overflow-hidden bg-gray-950 text-white">
            <nav class="border-b border-white/10 bg-gray-950/90">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-cyan-400 text-gray-950 shadow-lg shadow-cyan-400/20">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8" />
                                <path d="M10 18h4M10 6h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <path d="m14.5 11.5 3.2-3.2 1.4 1.4-3.2 3.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="text-lg font-bold tracking-normal text-white">
                            Repair Flow
                        </span>
                    </a>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md px-4 py-2 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-gray-950"
                            >
                                Login
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md bg-cyan-400 px-4 py-2 text-sm font-bold text-gray-950 shadow-lg shadow-cyan-400/20 transition hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-gray-950"
                            >
                                Register
                            </a>
                        @endif
                    </div>
                </div>
            </nav>

            <main class="mx-auto grid min-h-[calc(100vh-73px)] max-w-7xl items-center gap-12 px-6 py-14 lg:grid-cols-[1fr_520px] lg:px-8">
                <section class="max-w-3xl">
                    <p class="text-sm font-bold uppercase tracking-wide text-cyan-300">
                        Repair Flow
                    </p>

                    <h1 class="mt-5 max-w-2xl text-4xl font-extrabold leading-tight tracking-normal text-white sm:text-5xl lg:text-6xl">
                        Welcome to your repair login.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-300">
                        Login or register to manage smartphone repair tickets, track requests, and keep every customer update in one clean workflow.
                    </p>

                    <div class="mt-9 flex flex-wrap gap-3">
                        @if (Route::has('login'))
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md bg-white px-5 py-3 text-sm font-bold text-gray-950 shadow-xl shadow-black/20 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-950"
                            >
                                Login
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md border border-white/20 bg-white/5 px-5 py-3 text-sm font-bold text-white transition hover:border-cyan-300/70 hover:bg-cyan-300/10 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-gray-950"
                            >
                                Register
                            </a>
                        @endif
                    </div>

                    <div class="mt-10 grid max-w-2xl gap-3 sm:grid-cols-3">
                        <div class="rounded-md border border-white/10 bg-white/[.04] p-4">
                            <p class="text-2xl font-extrabold text-white">24/7</p>
                            <p class="mt-1 text-sm text-gray-400">Repair tracking</p>
                        </div>
                        <div class="rounded-md border border-white/10 bg-white/[.04] p-4">
                            <p class="text-2xl font-extrabold text-white">Fast</p>
                            <p class="mt-1 text-sm text-gray-400">Ticket updates</p>
                        </div>
                        <div class="rounded-md border border-white/10 bg-white/[.04] p-4">
                            <p class="text-2xl font-extrabold text-white">Clean</p>
                            <p class="mt-1 text-sm text-gray-400">Repair workflow</p>
                        </div>
                    </div>
                </section>

                <section class="relative flex min-h-[420px] items-center justify-center" aria-label="Animated smartphone repair illustration">
                    <div class="absolute inset-x-10 bottom-10 h-28 rounded-[50%] bg-cyan-400/10 blur-3xl"></div>

                    <svg class="relative h-auto w-full max-w-[520px]" viewBox="0 0 520 460" fill="none" role="img" aria-labelledby="repair-flow-title repair-flow-desc">
                        <title id="repair-flow-title">Repair Flow smartphone repair animation</title>
                        <desc id="repair-flow-desc">Animated smartphone with repair tools, scan line, sparks, and Repair Flow logo.</desc>

                        <g opacity=".35">
                            <path d="M93 372h334" stroke="#334155" stroke-width="2" stroke-linecap="round" />
                            <path d="M130 410h260" stroke="#1f2937" stroke-width="2" stroke-linecap="round" />
                        </g>

                        <g class="repair-phone">
                            <rect x="166" y="46" width="188" height="334" rx="34" fill="#020617" stroke="#67e8f9" stroke-width="3" />
                            <rect x="184" y="76" width="152" height="266" rx="20" fill="#111827" stroke="#1f2937" stroke-width="2" />
                            <path d="M232 62h56" stroke="#67e8f9" stroke-width="5" stroke-linecap="round" opacity=".9" />
                            <circle cx="260" cy="360" r="8" fill="#67e8f9" opacity=".8" />

                            <path d="M209 155h102M209 188h78M209 221h102" stroke="#334155" stroke-width="10" stroke-linecap="round" />
                            <path d="M221 278h78" stroke="#67e8f9" stroke-width="8" stroke-linecap="round" opacity=".9" />

                            <g class="repair-scan">
                                <rect x="196" y="92" width="128" height="4" rx="2" fill="#22d3ee" />
                                <rect x="196" y="96" width="128" height="30" fill="url(#scanGlow)" />
                            </g>

                            <g transform="translate(228 122)">
                                <rect x="0" y="0" width="64" height="64" rx="14" fill="#0f172a" stroke="#475569" stroke-width="2" />
                                <path d="m22 39 20-20M25 19h17v17" stroke="#67e8f9" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </g>

                        <g class="repair-tool" transform="translate(327 117) rotate(18)">
                            <path d="M34 12 88 66" stroke="#f8fafc" stroke-width="14" stroke-linecap="round" />
                            <path d="M22 0 47 25" stroke="#94a3b8" stroke-width="18" stroke-linecap="round" />
                            <path d="M75 55 102 82" stroke="#22d3ee" stroke-width="18" stroke-linecap="round" />
                        </g>

                        <g class="repair-tool" transform="translate(109 259) rotate(-24)" style="animation-delay: .8s;">
                            <path d="M21 84 81 24" stroke="#f8fafc" stroke-width="12" stroke-linecap="round" />
                            <path d="M69 12c13-11 31-11 43 0L92 32 80 20 100 0C88-5 77-1 69 12Z" fill="#22d3ee" />
                        </g>

                        <g transform="translate(344 274)">
                            <circle class="repair-spark" cx="18" cy="18" r="7" fill="#67e8f9" />
                            <circle class="repair-spark" cx="56" cy="46" r="5" fill="#f8fafc" />
                            <circle class="repair-spark" cx="26" cy="78" r="4" fill="#22d3ee" />
                        </g>

                        <g transform="translate(64 92)">
                            <rect x="0" y="0" width="118" height="56" rx="14" fill="#0f172a" stroke="#1f2937" stroke-width="2" />
                            <circle cx="28" cy="28" r="13" fill="#67e8f9" />
                            <path d="M51 21h42M51 35h28" stroke="#cbd5e1" stroke-width="5" stroke-linecap="round" />
                        </g>

                        <defs>
                            <linearGradient id="scanGlow" x1="260" x2="260" y1="96" y2="126" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#22d3ee" stop-opacity=".35" />
                                <stop offset="1" stop-color="#22d3ee" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </section>
            </main>
        </div>
    </body>
</html>
