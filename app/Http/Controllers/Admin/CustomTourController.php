<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomTourRequest;
use App\Models\CustomTour;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomTourController extends Controller
{
    /**
     * Display a filtered listing of custom tours.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'published' => ['nullable', 'in:0,1'],
        ]);

        $customTours = CustomTour::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('destination', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('published'), fn (Builder $query) => $query->where('is_published', $request->boolean('published')))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('admin.custom-tours.index', [
            'customTours' => $customTours,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new custom tour.
     */
    public function create(): View
    {
        return view('admin.custom-tours.create');
    }

    /**
     * Store a newly created custom tour.
     */
    public function store(CustomTourRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        CustomTour::create($data);

        return redirect()
            ->route('admin.custom-tours.index')
            ->with('status', 'Custom tour created successfully.');
    }

    /**
     * Show the form for editing the given custom tour.
     */
    public function edit(CustomTour $customTour): View
    {
        return view('admin.custom-tours.edit', [
            'customTour' => $customTour,
        ]);
    }

    /**
     * Update the given custom tour.
     */
    public function update(CustomTourRequest $request, CustomTour $customTour): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $customTour->update($data);

        return redirect()
            ->route('admin.custom-tours.index')
            ->with('status', 'Custom tour updated successfully.');
    }

    /**
     * Delete the given custom tour.
     */
    public function destroy(CustomTour $customTour): RedirectResponse
    {
        $customTour->delete();

        return redirect()
            ->route('admin.custom-tours.index')
            ->with('status', 'Custom tour deleted successfully.');
    }
}
