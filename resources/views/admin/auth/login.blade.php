<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-brand-navy font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10">
        <div class="mb-8 flex flex-col items-center gap-3">
            <x-admin.brand-logo size="h-12" framed />
            <p class="text-xs text-slate-400">Administrator Panel</p>
        </div>

        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl shadow-slate-950/30 sm:p-8">
            <h1 class="text-xl font-semibold text-brand-navy">Sign in</h1>
            <p class="mt-1 text-sm text-slate-500">Use your administrator account to continue.</p>

            @if (session('status'))
                <div class="mt-5 rounded-lg border border-brand-green/20 bg-brand-green/5 px-4 py-3 text-sm text-brand-green">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="mt-1.5 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="mt-1.5 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20"
                    >
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30"
                    >
                    Remember me on this device
                </label>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-lg bg-brand-green px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-green/90 focus:outline-none focus:ring-2 focus:ring-brand-green/40 focus:ring-offset-2"
                >
                    Sign in
                </button>
            </form>
        </div>

        <p class="mt-6 text-xs text-slate-500">Restricted area. Authorized administrators only.</p>
    </div>
</body>
</html>
