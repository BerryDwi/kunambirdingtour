@extends('admin.layouts.app')

@section('title', 'Edit hero slide')

@section('content')
    <x-admin.page-header title="Edit hero slide" :description="ucfirst(str_replace('-', ' ', $slide->page)).' hero'">
        <x-slot:actions>
            <a href="{{ route('admin.hero-slides.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Back to hero slides</a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="POST" action="{{ route('admin.hero-slides.update', $slide) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            @include('admin.hero-slides.partials.form', ['slide' => $slide, 'pages' => $pages])
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.hero-slides.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Cancel</a>
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-green px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-green/90">Save changes</button>
        </div>
    </form>
@endsection
