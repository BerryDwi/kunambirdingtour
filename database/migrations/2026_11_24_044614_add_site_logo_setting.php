<?php

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

        DB::table('settings')->insertOrIgnore([
            'key' => 'site_logo',
            'value' => '',
            'type' => 'string',
            'group' => 'general',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        Cache::forget('settings.values');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->where('key', 'site_logo')->delete();

        Cache::forget('settings.values');
    }
};
