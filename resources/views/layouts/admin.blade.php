<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>7-Tech Repair </title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
</head>

<body>
    <div class="min-h-screen antialiased bg-gray-900 dark:bg-gray-900">
        <nav
            class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-start items-center">
                    <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                        aria-controls="drawer-navigation"
                        class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mr-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/30 ring-1 ring-blue-400/30">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 1.5h3A2.25 2.25 0 0115.75 3.75v16.5A2.25 2.25 0 0113.5 22.5h-3a2.25 2.25 0 01-2.25-2.25V3.75A2.25 2.25 0 0110.5 1.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 18.75h2" />
                            </svg>
                        </span>
                        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">
                            7-Tech Repair
                        </span>
                    </a>
                </div>
                <div class="flex items-center lg:order-2">
                    <button type="button"
                        class="flex items-center gap-3 rounded-xl border border-white/10 bg-gray-900/40 px-3 py-2 text-left transition hover:bg-gray-700/70 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-sm font-bold text-white shadow-lg shadow-blue-900/30">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </span>
                        <span class="hidden min-w-0 sm:block">
                            <span class="block truncate text-sm font-semibold text-white">{{ auth()->user()->name ?? 'User' }}</span>
                            <span class="block max-w-56 truncate text-xs text-gray-400">{{ auth()->user()->email ?? 'Email unavailable' }}</span>
                        </span>
                        <svg class="hidden h-4 w-4 text-gray-400 sm:block" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div class="hidden z-50 my-4 w-64 overflow-hidden rounded-xl border border-white/10 bg-gray-800 text-base list-none shadow-2xl shadow-black/30"
                        id="dropdown">
                        <div class="border-b border-white/10 px-4 py-3">
                            <span class="block truncate text-sm font-semibold text-white">{{ auth()->user()->name ?? 'User' }}</span>
                            <span class="mt-1 block truncate text-sm text-gray-400">{{ auth()->user()->email ?? 'Email unavailable' }}</span>
                        </div>
                        <div class="py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm font-medium text-red-200 transition hover:bg-red-500/10 hover:text-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->

        <aside
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidenav" id="drawer-navigation">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
                <ul class="space-y-6">
                    @php
                        $isDevicesActive = request()->routeIs(
                            'brand.*',
                            'devicetype.*',
                            'devicemodel.*',
                            'spec-attribute.*',
                            'spec-attribute-option.*',
                        );
                    @endphp

                    <li>
                        <div class="mb-2 flex items-center gap-2 px-2">
                            <span class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></span>
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Inventory
                            </span>
                            <span class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></span>
                        </div>

                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('brand.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('brand.*')
                        ? 'bg-gray-100 text-gray-950 shadow-sm dark:bg-gray-700 dark:text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950 dark:text-gray-300 dark:hover:bg-gray-700/70 dark:hover:text-white' }}">
                                    @if (request()->routeIs('brand.*'))
                                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-500"></span>
                                    @endif
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200 transition group-hover:text-blue-500 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-700">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M4 4a2 2 0 012-2h4l6 6v8a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                            <path d="M11 2v5a1 1 0 001 1h5" fill="#111827" opacity=".35" />
                                        </svg>
                                    </span>
                                    <span class="truncate">Brands</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('devicetype.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('devicetype.*')
                        ? 'bg-gray-100 text-gray-950 shadow-sm dark:bg-gray-700 dark:text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950 dark:text-gray-300 dark:hover:bg-gray-700/70 dark:hover:text-white' }}">
                                    @if (request()->routeIs('devicetype.*'))
                                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-500"></span>
                                    @endif
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200 transition group-hover:text-blue-500 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-700">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M5 3a2 2 0 00-2 2v3h14V5a2 2 0 00-2-2H5zM3 10v5a2 2 0 002 2h10a2 2 0 002-2v-5H3z" />
                                        </svg>
                                    </span>
                                    <span class="truncate">Categories</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('spec-attribute.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('spec-attribute.*', 'spec-attribute-option.*')
                        ? 'bg-gray-100 text-gray-950 shadow-sm dark:bg-gray-700 dark:text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950 dark:text-gray-300 dark:hover:bg-gray-700/70 dark:hover:text-white' }}">
                                    @if (request()->routeIs('spec-attribute.*', 'spec-attribute-option.*'))
                                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-500"></span>
                                    @endif
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200 transition group-hover:text-blue-500 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-700">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.53 1.53 0 01-2.29.95c-1.37-.84-2.94.73-2.1 2.1a1.53 1.53 0 01-.95 2.29c-1.56.38-1.56 2.6 0 2.98a1.53 1.53 0 01.95 2.29c-.84 1.37.73 2.94 2.1 2.1a1.53 1.53 0 012.29.95c.38 1.56 2.6 1.56 2.98 0a1.53 1.53 0 012.29-.95c1.37.84 2.94-.73 2.1-2.1a1.53 1.53 0 01.95-2.29c1.56-.38 1.56-2.6 0-2.98a1.53 1.53 0 01-.95-2.29c.84-1.37-.73-2.94-2.1-2.1a1.53 1.53 0 01-2.29-.95zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span class="truncate">Attributes</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('devicemodel.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('devicemodel.*')
                        ? 'bg-gray-100 text-gray-950 shadow-sm dark:bg-gray-700 dark:text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950 dark:text-gray-300 dark:hover:bg-gray-700/70 dark:hover:text-white' }}">
                                    @if (request()->routeIs('devicemodel.*'))
                                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-500"></span>
                                    @endif
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200 transition group-hover:text-blue-500 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-700">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span class="truncate">Device Models</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    @php
                        $isRepairsActive = request()->routeIs('repair-tickets.*', 'repair-requests.index');
                    @endphp

                    <li>
                        <div class="mb-2 flex items-center gap-2 px-2">
                            <span class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></span>
                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Operations
                            </span>
                            <span class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></span>
                        </div>

                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('repair-tickets.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('repair-tickets.*')
                        ? 'bg-gray-100 text-gray-950 shadow-sm dark:bg-gray-700 dark:text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950 dark:text-gray-300 dark:hover:bg-gray-700/70 dark:hover:text-white' }}">
                                    @if (request()->routeIs('repair-tickets.*'))
                                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-500"></span>
                                    @endif
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200 transition group-hover:text-blue-500 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-700">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v2h14V5a2 2 0 00-2-2H5zm12 6H3v6a2 2 0 002 2h10a2 2 0 002-2V9zm-9 2a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <span class="truncate">Repair Tickets</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('repair-requests.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('repair-requests.*')
                        ? 'bg-gray-100 text-gray-950 shadow-sm dark:bg-gray-700 dark:text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-950 dark:text-gray-300 dark:hover:bg-gray-700/70 dark:hover:text-white' }}">
                                    @if (request()->routeIs('repair-requests.*'))
                                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-blue-500"></span>
                                    @endif
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-white text-gray-500 ring-1 ring-gray-200 transition group-hover:text-blue-500 dark:bg-gray-900 dark:text-gray-400 dark:ring-gray-700">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M2.94 6.34A2 2 0 014.77 5h10.46a2 2 0 011.83 1.34L10 10.77 2.94 6.34z" />
                                            <path d="M18 8.12V14a2 2 0 01-2 2H4a2 2 0 01-2-2V8.12l7.47 4.68a1 1 0 001.06 0L18 8.12z" />
                                        </svg>
                                    </span>
                                    <span class="truncate">Repair Requests</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>


            </div>
            <div
                class="hidden absolute bottom-0 left-0 w-full bg-white p-4 dark:bg-gray-800 lg:block">
                <div class="rounded-xl border border-amber-400/20 bg-amber-500/10 px-3 py-3 text-amber-100 shadow-lg shadow-black/10">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-400/15 text-amber-200 ring-1 ring-amber-300/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM10.29 3.86 1.82 18a2.25 2.25 0 001.93 3.38h16.5A2.25 2.25 0 0022.18 18L13.71 3.86a2.25 2.25 0 00-3.42 0z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">Demo version</p>
                            <p class="mt-0.5 text-xs leading-5 text-amber-100/80">Limited build, not ready for client delivery.</p>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <a href="https://mail.hostinger.com" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-amber-300/20 bg-black/20 px-2.5 py-2 text-xs font-semibold text-amber-50 transition hover:border-amber-200/50 hover:bg-amber-400/10 hover:text-white">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0-8.85 5.53a2.25 2.25 0 01-2.4 0L2.25 6.75" />
                            </svg>
                            Mailer
                        </a>

                        <a href="https://repair-request.eprostam.com" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-amber-300/20 bg-black/20 px-2.5 py-2 text-xs font-semibold text-amber-50 transition hover:border-amber-200/50 hover:bg-amber-400/10 hover:text-white">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            Frontend
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <main class="p-4 md:ml-64 min-h-screen pt-20 bg-gray-900">
            @yield('content')

        </main>
    </div>

    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

</body>

</html>
