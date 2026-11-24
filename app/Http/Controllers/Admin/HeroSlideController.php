<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SitePage;
use App\Http\Controllers\Admin\Concerns\ManagesImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSlideRequest;
use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    use ManagesImages;

    /**
     * Display a filtered listing of hero slides.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'hero_page' => ['nullable', 'string', 'max:50'],
            'active' => ['nullable', 'in:0,1'],
        ]);

        $slides = HeroSlide::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('alt', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('text', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('hero_page'), fn (Builder $query) => $query->where('page', $request->input('hero_page')))
            ->when($request->filled('active'), fn (Builder $query) => $query->where('is_active', $request->boolean('active')))
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.hero-slides.index', [
            'slides' => $slides,
            'filters' => $filters,
            'pages' => SitePage::values(),
        ]);
    }

    /**
     * Show the form for creating a new hero slide.
     */
    public function create(Request $request): View
    {
        return view('admin.hero-slides.create', [
            'pages' => SitePage::values(),
            'returnPage' => $this->resolveReturnPage($request->query('page')),
        ]);
    }

    /**
     * Store a newly created hero slide.
     */
    public function store(HeroSlideRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image_file']);

        $data['image'] = $this->resolveImage($request, 'image_file', 'image', null, 'hero-slides');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        HeroSlide::create($data);

        return $this->redirectAfterChange($request, 'Hero slide created successfully.');
    }

    /**
     * Show the form for editing the given hero slide.
     */
    public function edit(Request $request, HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', [
            'slide' => $heroSlide,
            'pages' => SitePage::values(),
            'returnPage' => $this->resolveReturnPage($request->query('page')),
        ]);
    }

    /**
     * Update the given hero slide.
     */
    public function update(HeroSlideRequest $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image_file']);

        $data['image'] = $this->resolveImage($request, 'image_file', 'image', $heroSlide->image, 'hero-slides');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $heroSlide->update($data);

        return $this->redirectAfterChange($request, 'Hero slide updated successfully.');
    }

    /**
     * Delete the given hero slide.
     */
    public function destroy(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $this->deleteStoredImage($heroSlide->image);

        $heroSlide->delete();

        return $this->redirectAfterChange($request, 'Hero slide deleted successfully.');
    }

    /**
     * Resolve a page settings return target from the request.
     */
    private function resolveReturnPage(mixed $value): ?SitePage
    {
        return is_string($value) ? SitePage::tryFrom($value) : null;
    }

    /**
     * Redirect back to page settings when the change was made there.
     */
    private function redirectAfterChange(Request $request, string $message): RedirectResponse
    {
        $returnPage = $this->resolveReturnPage($request->input('return_page'));

        if ($returnPage !== null) {
            return redirect()
                ->route('admin.pages.show', $returnPage->value)
                ->with('status', $message);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('status', $message);
    }
}
