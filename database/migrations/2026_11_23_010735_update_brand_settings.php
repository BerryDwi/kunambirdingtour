<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Settings that reference the legal entity and must keep their original wording.
     *
     * @var array<int, string>
     */
    private array $protectedKeys = ['company_name', 'bank_account_name'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->transformValues(
            fn (string $value): string => (string) preg_replace('/Birdtour Asia(?!\s+Ltd\b)(?!\s+Limited\b)/', 'Kunam Birding Tours', $value)
        );

        // The social preview image now comes from the local, optimised asset.
        DB::table('settings')->where('key', 'meta_image')->update(['value' => '']);

        // Query-builder updates bypass the model events that flush the settings cache.
        Cache::forget('settings.values');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->transformValues(
            fn (string $value): string => str_replace('Kunam Birding Tours', 'Birdtour Asia', $value)
        );

        DB::table('settings')->where('key', 'meta_image')->update([
            'value' => 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8c523028289f697f322d6e_Birdtour-Asia-CMYK-logo.png',
        ]);

        Cache::forget('settings.values');
    }

    /**
     * Apply a transformation to every non-legal setting value.
     *
     * @param  callable(string): string  $transform
     */
    private function transformValues(callable $transform): void
    {
        DB::table('settings')->orderBy('id')->chunkById(100, function ($settings) use ($transform): void {
            foreach ($settings as $setting) {
                if (in_array($setting->key, $this->protectedKeys, true)) {
                    continue;
                }

                $value = (string) $setting->value;
                $updated = $transform($value);

                if ($updated !== $value) {
                    DB::table('settings')->where('id', $setting->id)->update(['value' => $updated]);
                }
            }
        });
    }
};
