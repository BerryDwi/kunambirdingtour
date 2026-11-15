@props(['id', 'title' => 'Details'])

<dialog
    id="{{ $id }}"
    data-modal
    aria-labelledby="{{ $id }}-title"
    class="m-auto max-h-[90vh] w-[calc(100%-2rem)] max-w-4xl overflow-hidden rounded-2xl border border-slate-200 bg-white p-0 text-slate-800 shadow-2xl backdrop:bg-slate-900/60"
>
    <div class="flex max-h-[90vh] flex-col">
        <header class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-200 px-5 py-4">
            <h2 id="{{ $id }}-title" data-modal-title class="text-base font-semibold text-brand-navy">{{ $title }}</h2>

            <button type="button" data-modal-close class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </header>

        <div data-modal-body class="min-h-40 flex-1 overflow-y-auto px-5 py-5">
            {{ $slot }}
        </div>

        @if (isset($footer))
            <footer class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-5 py-3">
                {{ $footer }}
            </footer>
        @endif
    </div>
</dialog>
