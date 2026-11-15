@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
    <x-admin.page-header title="Contact Messages" description="General enquiries submitted through the website form.">
        <x-slot:actions>
            <a href="{{ route('admin.contact-messages.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Export CSV
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-4">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name, email or message" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
        </div>

        <div>
            <label for="status" class="block text-xs font-medium text-slate-500">Status</label>
            <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(($filters['status'] ?? null) === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($messages->isEmpty())
        <x-admin.empty-state title="No messages found" description="New enquiries from the contact form will appear here." />
    @else
        <x-admin.table :headings="['From', 'Email', 'Message', 'Status', 'Received', 'Actions']">
            @foreach ($messages as $message)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <p class="font-semibold text-slate-800">{{ $message->first_name }} {{ $message->last_name }}</p>
                        <p class="text-xs text-slate-400">{{ $message->phone ?: 'No phone' }}</p>
                    </td>

                    <td class="px-4 py-3">
                        <a href="mailto:{{ $message->email }}" class="text-sm text-brand-green underline-offset-2 hover:underline">{{ $message->email }}</a>
                    </td>

                    <td class="px-4 py-3">
                        <p class="max-w-md truncate text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($message->message, 90) }}</p>
                    </td>

                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$message->status" />
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-500">{{ $message->created_at?->format('d M Y') }}</td>

                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">View</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Showing {{ $messages->firstItem() }}-{{ $messages->lastItem() }} of {{ $messages->total() }} messages</p>
            {{ $messages->links() }}
        </div>
    @endif
@endsection
