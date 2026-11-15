<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TermsSectionRequest;
use App\Models\TermsSection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TermsSectionController extends Controller
{
    /**
     * Display a filtered listing of terms sections.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $sections = TermsSection::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.terms-sections.index', [
            'sections' => $sections,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new terms section.
     */
    public function create(): View
    {
        return view('admin.terms-sections.create');
    }

    /**
     * Store a newly created terms section.
     */
    public function store(TermsSectionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $data['number'];

        TermsSection::create($data);

        return redirect()
            ->route('admin.terms-sections.index')
            ->with('status', 'Terms section created successfully.');
    }

    /**
     * Show the form for editing the given terms section.
     */
    public function edit(TermsSection $termsSection): View
    {
        return view('admin.terms-sections.edit', [
            'section' => $termsSection,
        ]);
    }

    /**
     * Update the given terms section.
     */
    public function update(TermsSectionRequest $request, TermsSection $termsSection): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $data['number'];

        $termsSection->update($data);

        return redirect()
            ->route('admin.terms-sections.index')
            ->with('status', 'Terms section updated successfully.');
    }

    /**
     * Delete the given terms section.
     */
    public function destroy(TermsSection $termsSection): RedirectResponse
    {
        $termsSection->delete();

        return redirect()
            ->route('admin.terms-sections.index')
            ->with('status', 'Terms section deleted successfully.');
    }
}
