@extends('admin.layouts.app')

@section('title', 'Add product')

@section('content')
    <x-admin.page-header title="Add product" description="Create a product for the online shop.">
        <x-slot:actions>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Back to products</a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            @include('admin.products.partials.form', ['product' => null, 'currencies' => $currencies])
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Cancel</a>
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">Save product</button>
        </div>
    </form>
@endsection
