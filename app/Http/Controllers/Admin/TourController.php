<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TourStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TourRequest;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourController extends Controller
{
    /**
     * Display a filtered listing of tours.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'status' => ['nullable', Rule::enum(TourStatus::class)],
            'published' => ['nullable', 'in:0,1'],
        ]);

        $tours = Tour::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%");
                });
            })
            ->when($filters['year'] ?? null, fn (Builder $query, int|string $year) => $query->where('year', $year))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($request->filled('published'), fn (Builder $query) => $query->where('is_published', $request->boolean('published')))
            ->orderByDesc('year')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tours.index', [
            'tours' => $tours,
            'years' => Tour::query()->orderByDesc('year')->distinct()->pluck('year'),
            'statuses' => TourStatus::cases(),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new tour.
     */
    public function create(): View
    {
        return view('admin.tours.create', [
            'statuses' => TourStatus::cases(),
        ]);
    }

    /**
     * Return the tour detail partial used by the listing modal.
     */
    public function show(Tour $tour): View
    {
        return view('admin.tours.partials.details', [
            'tour' => $tour,
        ]);
    }

    /**
     * Store a newly created tour.
     */
    public function store(TourRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image_file']);

        $this->convertMoneyToMinorUnits($data);

        $data['image'] = $this->resolveImage($request);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Tour::create($data);

        return redirect()
            ->route('admin.tours.index')
            ->with('status', 'Tour created successfully.');
    }

    /**
     * Show the form for editing the given tour.
     */
    public function edit(Tour $tour): View
    {
        return view('admin.tours.edit', [
            'tour' => $tour,
            'statuses' => TourStatus::cases(),
        ]);
    }

    /**
     * Update the given tour.
     */
    public function update(TourRequest $request, Tour $tour): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image_file']);

        $this->convertMoneyToMinorUnits($data);

        $data['image'] = $this->resolveImage($request, $tour->image);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $tour->update($data);

        return redirect()
            ->route('admin.tours.index')
            ->with('status', 'Tour updated successfully.');
    }

    /**
     * Soft delete the given tour.
     */
    public function destroy(Tour $tour): RedirectResponse
    {
        $tour->delete();

        return redirect()
            ->route('admin.tours.index')
            ->with('status', 'Tour deleted successfully.');
    }

    /**
     * Convert validated money values from major units into minor units.
     *
     * @param  array<string, mixed>  $data
     */
    private function convertMoneyToMinorUnits(array &$data): void
    {
        foreach (['price_gbp', 'price_usd', 'single_supplement_gbp', 'single_supplement_usd'] as $field) {
            $value = $data[$field] ?? null;

            $data[$field] = $value === null || $value === ''
                ? null
                : (int) round(((float) $value) * 100);
        }
    }

    /**
     * Resolve the image value from an upload, the URL field, or the current value.
     */
    private function resolveImage(TourRequest $request, ?string $currentImage = null): ?string
    {
        if ($request->hasFile('image_file')) {
            $this->deleteImage($currentImage);

            return $request->file('image_file')->store('tours', 'public_uploads');
        }

        if ($request->boolean('remove_image')) {
            $this->deleteImage($currentImage);

            return null;
        }

        $image = $request->validated('image');

        return filled($image) ? $image : $currentImage;
    }

    /**
     * Delete a locally stored image. External URLs are left untouched.
     */
    private function deleteImage(?string $image): void
    {
        if (filled($image) && ! Str::startsWith($image, ['http://', 'https://', '//'])) {
            Storage::disk('public_uploads')->delete($image);
        }
    }
}
