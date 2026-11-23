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
        $this->updateValue('Booking with us & Flowchart - Kunam Birding Tours', 'Booking with us - Kunam Birding Tours');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->updateValue('Booking with us - Kunam Birding Tours', 'Booking with us & Flowchart - Kunam Birding Tours');
    }

    /**
     * Replace the booking page meta title and flush the cached settings map.
     */
    private function updateValue(string $search, string $replace): void
    {
        DB::table('settings')
            ->where('key', 'meta_title_booking')
            ->where('value', $search)
            ->update(['value' => $replace]);

        Cache::forget('settings.values');
    }
};
