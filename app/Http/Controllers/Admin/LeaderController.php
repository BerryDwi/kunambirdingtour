<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaderRequest;
use App\Models\Leader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaderController extends Controller
{
    use ManagesImages;

    /**
     * Display a filtered listing of leaders.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'published' => ['nullable', 'in:0,1'],
        ]);

        $leaders = Leader::query()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('published'), fn (Builder $query) => $query->where('is_published', $request->boolean('published')))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('admin.leaders.index', [
            'leaders' => $leaders,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new leader.
     */
    public function create(): View
    {
        return view('admin.leaders.create');
    }

    /**
     * Store a newly created leader.
     */
    public function store(LeaderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['photo_file']);

        $data['photo'] = $this->resolveImage($request, 'photo_file', 'photo', null, 'leaders');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Leader::create($data);

        return redirect()
            ->route('admin.leaders.index')
            ->with('status', 'Leader created successfully.');
    }

    /**
     * Show the form for editing the given leader.
     */
    public function edit(Leader $leader): View
    {
        return view('admin.leaders.edit', [
            'leader' => $leader,
        ]);
    }

    /**
     * Update the given leader.
     */
    public function update(LeaderRequest $request, Leader $leader): RedirectResponse
    {
        $data = $request->validated();
        unset($data['photo_file']);

        $data['photo'] = $this->resolveImage($request, 'photo_file', 'photo', $leader->photo, 'leaders');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $leader->update($data);

        return redirect()
            ->route('admin.leaders.index')
            ->with('status', 'Leader updated successfully.');
    }

    /**
     * Delete the given leader.
     */
    public function destroy(Leader $leader): RedirectResponse
    {
        $leader->delete();

        return redirect()
            ->route('admin.leaders.index')
            ->with('status', 'Leader deleted successfully.');
    }
}
