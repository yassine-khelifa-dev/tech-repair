@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-7xl space-y-8">
        <section class="overflow-hidden rounded-xl border border-white/10 bg-gray-800/70 shadow-2xl shadow-black/20">
            <div class="grid gap-8 p-6 lg:grid-cols-[1.35fr_.65fr] lg:p-8">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">
                        Dashboard
                    </p>

                    <h1 class="mt-3 max-w-3xl text-3xl font-bold leading-tight text-white md:text-4xl">
                        Start here before creating repair tickets.
                    </h1>

                    <p class="mt-4 max-w-3xl text-base leading-7 text-gray-300">
                        The application works best when the setup is done in order: create the brand, create the
                        category, define the attributes for that category, then create the model and choose which
                        attribute options are valid for it. After that, the repair ticket form only shows the options
                        that belong to the selected model.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('brand.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition hover:bg-blue-500">
                            Start setup
                        </a>

                        <a href="{{ route('repair-tickets.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white">
                            Create ticket
                        </a>
                    </div>
                </div>

                <div class="rounded-xl border border-blue-400/20 bg-blue-500/10 p-5">
                    <h2 class="text-base font-semibold text-white">Why this setup matters</h2>
                    <p class="mt-3 text-sm leading-6 text-blue-100/90">
                        If the catalog is not configured, users may be blocked when creating tickets because the
                        right model options will not be available.
                    </p>

                    <div class="mt-5 rounded-lg border border-white/10 bg-gray-950/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Example</p>
                        <p class="mt-2 text-sm text-white">
                            iPhone 17 Pro Max can show only Blue, White, 8GB RAM, and selected storage options.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="mb-5">
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Setup guide</p>
                <h2 class="mt-1 text-2xl font-bold text-white">Configure in this order</h2>
                <p class="mt-2 text-sm text-gray-400">
                    Follow these steps once. After that, ticket creation becomes simple for the team.
                </p>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <a href="{{ route('brand.index') }}"
                    class="group rounded-xl border border-white/10 bg-gray-800/70 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-blue-300/40 hover:bg-gray-800">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-sm font-bold text-blue-200 ring-1 ring-blue-400/20">
                            01
                        </span>
                        <div>
                            <h3 class="font-semibold text-white">Create brands</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-400">
                                Add manufacturers like Apple, Samsung, Xiaomi, Dell, HP, and others.
                            </p>
                            <p class="mt-3 text-sm font-semibold text-blue-300">Open brands -></p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('devicetype.index') }}"
                    class="group rounded-xl border border-white/10 bg-gray-800/70 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-blue-300/40 hover:bg-gray-800">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-sm font-bold text-blue-200 ring-1 ring-blue-400/20">
                            02
                        </span>
                        <div>
                            <h3 class="font-semibold text-white">Create categories</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-400">
                                Add device categories such as Smartphone, Tablet, Laptop, Console, or Smartwatch.
                            </p>
                            <p class="mt-3 text-sm font-semibold text-blue-300">Open categories -></p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('spec-attribute.index') }}"
                    class="group rounded-xl border border-white/10 bg-gray-800/70 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-blue-300/40 hover:bg-gray-800">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-sm font-bold text-blue-200 ring-1 ring-blue-400/20">
                            03
                        </span>
                        <div>
                            <h3 class="font-semibold text-white">Create category attributes</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-400">
                                Create the fields needed for the category. For Smartphone, add Color, RAM, and Storage with their options.
                            </p>
                            <p class="mt-3 text-sm font-semibold text-blue-300">Open attributes -></p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('devicemodel.index') }}"
                    class="group rounded-xl border border-white/10 bg-gray-800/70 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-blue-300/40 hover:bg-gray-800">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-sm font-bold text-blue-200 ring-1 ring-blue-400/20">
                            04
                        </span>
                        <div>
                            <h3 class="font-semibold text-white">Create device models</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-400">
                                Create the model after its brand, category, and attributes exist. Example: Apple + Smartphone + iPhone 17 Pro Max.
                            </p>
                            <p class="mt-3 text-sm font-semibold text-blue-300">Open device models -></p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('devicemodel.index') }}"
                    class="group rounded-xl border border-amber-400/20 bg-amber-500/10 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-amber-300/50">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-sm font-bold text-amber-200 ring-1 ring-amber-400/20">
                            05
                        </span>
                        <div>
                            <h3 class="font-semibold text-white">Configure each model</h3>
                            <p class="mt-1 text-sm leading-6 text-amber-100/80">
                                In Device Models, use the configure action and choose only the values this model supports.
                                For iPhone 17 Pro Max, keep Color: Blue and White, RAM: 8GB, and the selected storage values.
                            </p>
                            <p class="mt-3 text-sm font-semibold text-amber-200">Choose a model to configure -></p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('repair-tickets.create') }}"
                    class="group rounded-xl border border-emerald-400/20 bg-emerald-500/10 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-emerald-300/50">
                    <div class="flex items-start gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 text-sm font-bold text-emerald-200 ring-1 ring-emerald-400/20">
                            06
                        </span>
                        <div>
                            <h3 class="font-semibold text-white">Create repair tickets</h3>
                            <p class="mt-1 text-sm leading-6 text-emerald-100/80">
                                Select the customer device. The form will show only the options configured for that model.
                            </p>
                            <p class="mt-3 text-sm font-semibold text-emerald-200">Create repair ticket -></p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section class="grid gap-5 lg:grid-cols-[1fr_.9fr]">
            <div class="rounded-xl border border-white/10 bg-gray-800/70 p-6 shadow-xl shadow-black/10">
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-300">Concrete example</p>
                <h2 class="mt-2 text-2xl font-bold text-white">Scenario: iPhone 17 Pro Max</h2>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-lg border border-white/10 bg-gray-950/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">1. Brand</p>
                        <p class="mt-1 font-semibold text-white">Apple</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-gray-950/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">2. Category</p>
                        <p class="mt-1 font-semibold text-white">Smartphone</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-gray-950/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">3. Attributes</p>
                        <p class="mt-1 font-semibold text-white">Color, RAM, Storage</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-gray-950/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">4. Model</p>
                        <p class="mt-1 font-semibold text-white">iPhone 17 Pro Max</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-gray-950/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">5. Model options</p>
                        <p class="mt-1 font-semibold text-white">Blue, White, 8GB RAM, 256GB, 512GB, 1TB</p>
                    </div>
                    <div class="rounded-lg border border-emerald-400/20 bg-emerald-500/10 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-300">6. Ticket result</p>
                        <p class="mt-1 font-semibold text-white">The ticket shows only those six configured values.</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-white/10 bg-gray-800/70 p-6 shadow-xl shadow-black/10">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">Daily work</p>
                <h2 class="mt-2 text-2xl font-bold text-white">After setup</h2>
                <p class="mt-3 text-sm leading-6 text-gray-400">
                    Use the Repair Center for the daily workflow: review incoming repair requests, create tickets,
                    update statuses, add logs, upload photos, and communicate progress.
                </p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('repair-requests.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-gray-200 transition hover:bg-white/10 hover:text-white">
                        Review requests
                    </a>
                    <a href="{{ route('repair-tickets.index') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-500">
                        Open tickets
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
