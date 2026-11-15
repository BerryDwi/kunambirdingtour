@extends('admin.layouts.app')

@section('title', 'Add tour')

@section('content')
    <x-admin.page-header title="Add tour" description="Create a scheduled departure or a custom itinerary.">
        <x-slot:actions>
            <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Back to tours
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <form method="POST" action="{{ route('admin.tours.store') }}" enctype="multipart/form-data" class="space-y-6" novalidate>
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            @include('admin.tours.partials.form', ['tour' => null])
        </div>
    </form>
@endsection
