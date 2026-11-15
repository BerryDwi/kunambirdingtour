@props(['title' => 'No records yet', 'description' => null])

<div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
    <p class="text-sm font-semibold text-slate-700">{{ $title }}</p>

    @if ($description)
        <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
    @endif

    @if (isset($action))
        <div class="mt-4">{{ $action }}</div>
    @endif
</div>
