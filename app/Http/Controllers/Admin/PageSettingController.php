<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SitePage;
use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSettingController extends Controller
{
    /**
     * Show the hero slides and editable text for a single public page.
     */
    public function show(SitePage $page): View
    {
        return view('admin.pages.show', [
            'page' => $page,
            'settings' => Setting::query()
                ->where('group', $page->value)
                ->orderBy('key')
                ->get(),
            'slides' => HeroSlide::query()
                ->onPage($page->value)
                ->ordered()
                ->get(),
        ]);
    }

    /**
     * Update the text settings that belong to a single public page.
     */
    public function update(Request $request, SitePage $page): RedirectResponse
    {
        $data = $request->validate([
            'values' => ['required', 'array'],
            'values.*' => ['nullable', 'string'],
        ]);

        foreach (Setting::query()->where('group', $page->value)->get() as $setting) {
            if (array_key_exists($setting->id, $data['values'])) {
                $setting->update(['value' => $data['values'][$setting->id]]);
            }
        }

        return redirect()
            ->route('admin.pages.show', $page->value)
            ->with('status', 'Settings for '.$page->label().' updated successfully.');
    }
}
