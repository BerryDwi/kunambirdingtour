@extends('admin.layouts.app')

@section('title', 'Message from '.$contactMessage->first_name.' '.$contactMessage->last_name)

@section('content')
    <x-admin.page-header :title="'Message from '.$contactMessage->first_name.' '.$contactMessage->last_name" :description="$contactMessage->email">
        <x-slot:actions>
            <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Back to messages</a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="grid gap-5 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Message</h2>
                    <x-admin.status-badge :status="$contactMessage->status" />
                </div>

                <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $contactMessage->message }}</p>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Sender</h2>

                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Name</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-800">{{ $contactMessage->first_name }} {{ $contactMessage->last_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Email</dt>
                        <dd class="mt-1 text-sm text-slate-800"><a href="mailto:{{ $contactMessage->email }}" class="text-brand-green underline-offset-2 hover:underline">{{ $contactMessage->email }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Phone</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $contactMessage->phone ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Received</dt>
                        <dd class="mt-1 text-sm text-slate-800">{{ $contactMessage->created_at?->format('d M Y H:i') }}</dd>
                    </div>
                </dl>

                <a href="mailto:{{ $contactMessage->email }}" class="mt-5 inline-flex items-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">Reply by email</a>
            </section>
        </div>

        <div class="space-y-5">
            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700">Status</h2>
                <p class="mt-2 text-sm text-slate-500">Opening a new message marks it as read automatically.</p>

                <form method="POST" action="{{ route('admin.contact-messages.update', $contactMessage) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-xs font-medium text-slate-500">Message status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected($contactMessage->status === $status)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">Update status</button>
                </form>
            </section>

            <section class="rounded-xl border border-red-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-red-600">Danger zone</h2>
                <p class="mt-2 text-sm text-slate-500">This permanently removes the message from the inbox.</p>

                <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" onsubmit="return confirm('Delete this message?');" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg border border-red-300 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">Delete message</button>
                </form>
            </section>
        </div>
    </div>
@endsection
