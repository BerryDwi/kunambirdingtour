<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TourReportRequest;
use App\Models\TourReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourReportController extends Controller
{
    use ManagesImages;

    /**
     * Display a filtered listing of tour reports.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'published' => ['nullable', 'in:0,1'],
            'featured' => ['nullable', 'in:0,1'],
        ]);

        $reports = TourReport::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('published'), fn (Builder $query) => $query->where('is_published', $request->boolean('published')))
            ->when($request->filled('featured'), fn (Builder $query) => $query->where('is_featured', $request->boolean('featured')))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('admin.tour-reports.index', [
            'reports' => $reports,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new tour report.
     */
    public function create(): View
    {
        return view('admin.tour-reports.create');
    }

    /**
     * Store a newly created tour report.
     */
    public function store(TourReportRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['cover_image_file']);

        $data['cover_image'] = $this->resolveImage($request, 'cover_image_file', 'cover_image', null, 'reports');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        TourReport::create($data);

        return redirect()
            ->route('admin.tour-reports.index')
            ->with('status', 'Tour report created successfully.');
    }

    /**
     * Show the form for editing the given tour report.
     */
    public function edit(TourReport $tourReport): View
    {
        return view('admin.tour-reports.edit', [
            'report' => $tourReport,
        ]);
    }

    /**
     * Update the given tour report.
     */
    public function update(TourReportRequest $request, TourReport $tourReport): RedirectResponse
    {
        $data = $request->validated();
        unset($data['cover_image_file']);

        $data['cover_image'] = $this->resolveImage($request, 'cover_image_file', 'cover_image', $tourReport->cover_image, 'reports');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $tourReport->update($data);

        return redirect()
            ->route('admin.tour-reports.index')
            ->with('status', 'Tour report updated successfully.');
    }

    /**
     * Delete the given tour report.
     */
    public function destroy(TourReport $tourReport): RedirectResponse
    {
        $tourReport->delete();

        return redirect()
            ->route('admin.tour-reports.index')
            ->with('status', 'Tour report deleted successfully.');
    }
}
