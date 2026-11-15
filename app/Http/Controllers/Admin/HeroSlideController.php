<?php

namespace App\Http\Controllers\Admin;

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
            'pages' => HeroSlideRequest::PAGES,
        ]);
    }

    /**
     * Show the form for creating a new hero slide.
     */
    public function create(): View
    {
        return view('admin.hero-slides.create', [
            'pages' => HeroSlideRequest::PAGES,
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

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('status', 'Hero slide created successfully.');
    }

    /**
     * Show the form for editing the given hero slide.
     */
    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', [
            'slide' => $heroSlide,
            'pages' => HeroSlideRequest::PAGES,
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

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('status', 'Hero slide updated successfully.');
    }

    /**
     * Delete the given hero slide.
     */
    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        $this->deleteStoredImage($heroSlide->image);

        $heroSlide->delete();

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('status', 'Hero slide deleted successfully.');
    }
}
