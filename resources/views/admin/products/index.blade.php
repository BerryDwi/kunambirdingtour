@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <x-admin.page-header title="Products" description="Manage merchandise and field equipment shown on the website.">
        <x-slot:actions>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-green px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">
                <span class="text-base leading-none">+</span>
                Add product
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-5 grid gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-4">
        <div class="lg:col-span-2">
            <label for="search" class="block text-xs font-medium text-slate-500">Search</label>
            <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name or slug" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
        </div>

        <div>
            <label for="active" class="block text-xs font-medium text-slate-500">Availability</label>
            <select id="active" name="active" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20">
                <option value="">All</option>
                <option value="1" @selected(($filters['active'] ?? null) === '1')>Active</option>
                <option value="0" @selected(($filters['active'] ?? null) === '0')>Inactive</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-navy px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-navy/90">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($products->isEmpty())
        <x-admin.empty-state title="No products found" description="Try adjusting the filters, or add your first product." />
    @else
        <x-admin.table :headings="['Product', 'Price', 'Availability', 'Purchase link', 'Actions']">
            @foreach ($products as $product)
                <tr class="align-middle transition hover:bg-slate-50/70">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if ($product->imageUrl())
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="size-12 shrink-0 rounded-lg object-cover" loading="lazy">
                            @else
                                <span class="grid size-12 shrink-0 place-items-center rounded-lg bg-slate-100 text-[10px] font-semibold text-slate-400">N/A</span>
                            @endif

                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-800">{{ $product->name }}</p>
                                <p class="truncate text-xs text-slate-400">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-slate-600">
                        @if ($product->price !== null)
                            {{ $product->currency?->symbol() }}{{ number_format($product->price / 100, 2) }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        <x-admin.status-badge :status="$product->is_active ? 'active' : 'inactive'" />
                    </td>

                    <td class="px-4 py-3">
                        @if ($product->purchase_url)
                            <a href="{{ $product->purchase_url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-brand-green underline-offset-2 hover:underline">Open link</a>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="rounded-md border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50">Edit</a>

                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md border border-red-200 px-2.5 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products</p>
            {{ $products->links() }}
        </div>
    @endif
@endsection
