<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Human-readable labels for the known setting groups.
     *
     * @var array<string, string>
     */
    private const GROUP_LABELS = [
        'general' => 'General',
        'contact' => 'Contact',
        'bank' => 'Bank Details',
        'social' => 'Social',
        'home' => 'Home Page',
        'seo' => 'SEO',
    ];

    /**
     * Display settings grouped for bulk editing.
     */
    public function index(Request $request): View
    {
        $settings = Setting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        $groups = $settings
            ->map(fn ($groupSettings, string $group): array => [
                'key' => $group,
                'label' => self::GROUP_LABELS[$group] ?? ucfirst($group),
                'count' => $groupSettings->count(),
            ])
            ->values();

        $requestedGroup = (string) $request->query('group', '');
        $activeGroup = $settings->has($requestedGroup) ? $requestedGroup : $settings->keys()->first();
        $activeGroupData = $groups->firstWhere('key', $activeGroup);

        return view('admin.settings.index', [
            'groups' => $groups,
            'activeGroup' => $activeGroup,
            'activeLabel' => $activeGroupData['label'] ?? null,
            'activeSettings' => $activeGroup ? $settings->get($activeGroup) : collect(),
        ]);
    }

    /**
     * Show the form for creating a new setting inside a group.
     */
    public function create(Request $request): View
    {
        $groupKeys = Setting::query()
            ->distinct()
            ->orderBy('group')
            ->pluck('group');

        $requestedGroup = (string) $request->query('group', '');
        $group = $groupKeys->contains($requestedGroup) ? $requestedGroup : ($groupKeys->first() ?? 'general');

        return view('admin.settings.create', [
            'group' => $group,
            'groupLabel' => self::GROUP_LABELS[$group] ?? ucfirst($group),
            'types' => ['string', 'text', 'boolean', 'number'],
        ]);
    }

    /**
     * Store a newly created setting.
     */
    public function store(SettingRequest $request): RedirectResponse
    {
        $setting = Setting::create($request->validated());

        return redirect()
            ->route('admin.settings.index', ['group' => $setting->group])
            ->with('status', 'Setting created successfully.');
    }

    /**
     * Update every setting value in the given group.
     */
    public function updateGroup(Request $request, string $group): RedirectResponse
    {
        $data = $request->validate([
            'values' => ['required', 'array'],
            'values.*' => ['nullable', 'string'],
        ]);

        $settings = Setting::query()->where('group', $group)->get();

        foreach ($settings as $setting) {
            if (array_key_exists($setting->id, $data['values'])) {
                $setting->update(['value' => $data['values'][$setting->id]]);
            }
        }

        return redirect()
            ->route('admin.settings.index', ['group' => $group])
            ->with('status', 'Settings for "'.$group.'" updated successfully.');
    }

    /**
     * Delete the given setting.
     */
    public function destroy(Setting $setting): RedirectResponse
    {
        $group = $setting->group;

        $setting->delete();

        return redirect()
            ->route('admin.settings.index', $group ? ['group' => $group] : [])
            ->with('status', 'Setting deleted successfully.');
    }
}
