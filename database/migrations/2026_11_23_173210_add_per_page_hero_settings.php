<?php

use App\Enums\SitePage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $timestamp = now();

        foreach (SitePage::cases() as $page) {
            foreach ($page->heroSettingDefaults() as $key => $value) {
                DB::table('settings')->insertOrIgnore([
                    'key' => $key,
                    'value' => $value,
                    'type' => str_ends_with($key, '_body') || str_ends_with($key, '_text') ? 'text' : 'string',
                    'group' => $page->value,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }
        }

        Cache::forget('settings.values');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [];

        foreach (SitePage::cases() as $page) {
            $keys = [...$keys, ...array_keys($page->heroSettingDefaults())];
        }

        DB::table('settings')->whereIn('key', $keys)->delete();

        Cache::forget('settings.values');
    }
};
