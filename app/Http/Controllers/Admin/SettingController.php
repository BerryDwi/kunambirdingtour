<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    use ManagesImages;

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
        $settingsByGroup = Setting::query()
            ->whereIn('group', array_keys(self::GROUP_LABELS))
            ->where('key', '!=', 'site_logo')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        $settings = collect(array_keys(self::GROUP_LABELS))
            ->filter(fn (string $group): bool => $settingsByGroup->has($group))
            ->mapWithKeys(fn (string $group): array => [$group => $settingsByGroup->get($group)]);

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
            'logoUrl' => Setting::logoUrl(),
            'hasCustomLogo' => Setting::hasCustomLogo(),
        ]);
    }

    /**
     * Show the form for creating a new setting inside a group.
     */
    public function create(Request $request): View
    {
        $existingGroups = Setting::query()
            ->whereIn('group', array_keys(self::GROUP_LABELS))
            ->distinct()
            ->pluck('group');

        $groupKeys = collect(array_keys(self::GROUP_LABELS))
            ->filter(fn (string $group): bool => $existingGroups->contains($group))
            ->values();

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
     * Upload, link or reset the site logo.
     */
    public function updateLogo(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo_url' => ['nullable', 'url:http,https', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
        ]);

        $current = (string) (Setting::values()['site_logo'] ?? '');

        if ($request->boolean('remove_logo')) {
            $this->deleteStoredImage($current);
            $logo = '';
        } elseif ($request->hasFile('logo')) {
            $this->deleteStoredImage($current);
            $logo = (string) $request->file('logo')->store('branding', 'public_uploads');
        } elseif (filled($request->input('logo_url'))) {
            $this->deleteStoredImage($current);
            $logo = trim((string) $request->input('logo_url'));
        } else {
            return back()->withErrors(['logo' => 'Choose an image file or paste an image URL before saving.']);
        }

        Setting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => $logo, 'type' => 'string', 'group' => 'general'],
        );

        return redirect()
            ->route('admin.settings.index', ['group' => 'general'])
            ->with('status', 'Site logo updated successfully.');
    }

    /**
     * Update every setting value in the given group.
     */
    public function updateGroup(Request $request, string $group): RedirectResponse
    {
        abort_unless(in_array($group, array_keys(self::GROUP_LABELS), true), 404);

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
