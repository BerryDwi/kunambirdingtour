@php
    $navigationGroups = [
        [
            'label' => 'Home',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')],
            ],
        ],
        [
            'label' => 'Content',
            'items' => [
                ['label' => 'Tours', 'route' => 'admin.tours.index', 'active' => request()->routeIs('admin.tours.*')],
                ['label' => 'Leaders', 'route' => 'admin.leaders.index', 'active' => request()->routeIs('admin.leaders.*')],
                ['label' => 'Tour Reports', 'route' => 'admin.tour-reports.index', 'active' => request()->routeIs('admin.tour-reports.*')],
                ['label' => 'Custom Tours', 'route' => 'admin.custom-tours.index', 'active' => request()->routeIs('admin.custom-tours.*')],
                ['label' => 'Terms', 'route' => 'admin.terms-sections.index', 'active' => request()->routeIs('admin.terms-sections.*')],
                ['label' => 'Products', 'route' => 'admin.products.index', 'active' => request()->routeIs('admin.products.*')],
            ],
        ],
        [
            'label' => 'Site',
            'items' => [
                ['label' => 'Hero Slides', 'route' => 'admin.hero-slides.index', 'active' => request()->routeIs('admin.hero-slides.*')],
                ['label' => 'Settings', 'route' => 'admin.settings.index', 'active' => request()->routeIs('admin.settings.*')],
            ],
        ],
        [
            'label' => 'Inbox',
            'items' => [
                ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'active' => request()->routeIs('admin.bookings.*')],
                ['label' => 'Contact Messages', 'route' => 'admin.contact-messages.index', 'active' => request()->routeIs('admin.contact-messages.*')],
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }} Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased lg:h-screen lg:overflow-hidden">
    <div class="min-h-screen lg:flex lg:h-screen">
        <input id="admin-sidebar-toggle" type="checkbox" class="peer sr-only">

        <header class="flex items-center justify-between gap-4 border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <x-admin.brand-logo size="h-8" />
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Admin</span>
            </a>
            <label for="admin-sidebar-toggle" class="cursor-pointer rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Menu
            </label>
        </header>

        <aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-brand-navy text-slate-200 transition-transform duration-200 ease-out peer-checked:translate-x-0 lg:static lg:h-full lg:translate-x-0">
            <div class="flex shrink-0 flex-col gap-2 border-b border-white/10 px-5 py-5">
                <x-admin.brand-logo size="h-9" framed />
                <p class="text-xs text-slate-400">Admin Panel</p>
            </div>

            <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto overscroll-contain scrollbar-none px-3 py-4">
                @foreach ($navigationGroups as $group)
                    <p class="px-2 pb-2 {{ $loop->first ? '' : 'pt-5' }} text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ $group['label'] }}</p>

                    @foreach ($group['items'] as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            @class([
                                'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition',
                                'bg-white/10 text-white' => $item['active'],
                                'text-slate-300 hover:bg-white/5 hover:text-white' => ! $item['active'],
                            ])
                        >
                            <span class="size-1.5 rounded-full {{ $item['active'] ? 'bg-brand-green' : 'bg-slate-600' }}"></span>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                @endforeach
            </nav>

            <div class="shrink-0 border-t border-white/10 p-3">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg border border-white/15 px-3 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10 hover:text-white">
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        <label for="admin-sidebar-toggle" class="fixed inset-0 z-30 hidden bg-slate-900/50 peer-checked:block lg:hidden" aria-hidden="true"></label>

        <div class="flex min-w-0 flex-1 flex-col scrollbar-none lg:h-full lg:overflow-y-auto">
            <header class="hidden items-center justify-between gap-4 border-b border-slate-200 bg-white px-6 py-4 lg:sticky lg:top-0 lg:z-20 lg:flex">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-500">Admin</p>
                    <h1 class="text-lg font-semibold text-brand-navy">@yield('title', 'Dashboard')</h1>
                </div>

                <details class="group relative" data-user-menu>
                    <summary class="flex cursor-pointer list-none items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-slate-100 [&::-webkit-details-marker]:hidden">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()?->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()?->email }}</p>
                        </div>
                        <span class="grid size-9 place-items-center rounded-full bg-brand-navy text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                        </span>
                        <svg class="size-4 text-slate-400 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </summary>

                    <div class="absolute right-0 z-50 mt-2 w-60 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                        <div class="border-b border-slate-100 px-4 py-3">
                            <p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()?->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()?->email }}</p>
                        </div>

                        <div class="p-2">
                            <a href="{{ route('admin.profile.show') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-brand-navy">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </details>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('status'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border border-brand-green/20 bg-brand-green/5 px-4 py-3 text-sm text-brand-green">
                        <span class="mt-0.5 size-2 shrink-0 rounded-full bg-brand-green"></span>
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="border-t border-slate-200 px-6 py-4 text-xs text-slate-500">
                &copy; {{ now()->year }} {{ config('app.name') }}. Administrator area.
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
