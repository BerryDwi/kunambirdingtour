@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
    @php
        $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    @endphp

    <x-admin.page-header title="Profile" description="Your administrator account details." />

    <div class="max-w-3xl">
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-5">
                <span class="grid size-14 place-items-center rounded-full bg-brand-navy text-lg font-semibold text-white">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-lg font-semibold text-brand-navy">{{ $user->name }}</p>
                    <p class="truncate text-sm text-slate-500">{{ $user->email }}</p>
                </div>
                <div class="ml-auto hidden text-right text-xs text-slate-500 sm:block">
                    <p class="font-semibold uppercase tracking-wide text-slate-400">Administrator</p>
                    <p>Member since {{ $user->created_at?->format('d M Y') ?? '—' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="grid gap-5 p-5 sm:grid-cols-2">
                    <x-admin.form.field label="Name" name="name">
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" class="{{ $inputClass }}">
                    </x-admin.form.field>

                    <x-admin.form.field label="Email" name="email" hint="Used to sign in to the admin panel.">
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="{{ $inputClass }}">
                    </x-admin.form.field>
                </div>

                <div class="border-t border-slate-100 px-5 py-5">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Change password</h2>
                    <p class="mt-1 text-xs text-slate-500">Leave these fields blank to keep your current password.</p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-admin.form.field label="Current password" name="current_password">
                                <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="{{ $inputClass }}">
                            </x-admin.form.field>
                        </div>

                        <x-admin.form.field label="New password" name="password" hint="Minimum 8 characters.">
                            <input id="password" name="password" type="password" autocomplete="new-password" class="{{ $inputClass }}">
                        </x-admin.form.field>

                        <x-admin.form.field label="Confirm new password" name="password_confirmation">
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="{{ $inputClass }}">
                        </x-admin.form.field>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 bg-slate-50/60 px-5 py-3">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                        Save changes
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-4 flex justify-end">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                    Log out
                </button>
            </form>
        </div>
    </div>
@endsection
