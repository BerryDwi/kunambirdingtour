<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BrandingTest extends TestCase
{
    use RefreshDatabase;

    private const LOGO = 'images/kunam-logo.jpg';

    public function test_login_page_uses_the_kunam_logo(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee(self::LOGO, false)
            ->assertSee('alt="Kunam Birding Tours"', false)
            ->assertDontSee('>BA<', false);
    }

    public function test_admin_layout_uses_the_kunam_logo(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(self::LOGO, false)
            ->assertSee('alt="Kunam Birding Tours"', false)
            ->assertDontSee('>BA<', false);
    }

    public function test_general_settings_show_the_current_logo_and_upload_form(): void
    {
        $this->seed(SettingSeeder::class);

        $this->actingAs($this->admin())
            ->get(route('admin.settings.index', ['group' => 'general']))
            ->assertOk()
            ->assertSee('Site logo')
            ->assertSee('Current logo in use')
            ->assertSee(self::LOGO, false)
            ->assertSee('name="logo"', false)
            ->assertSee('name="logo_url"', false)
            ->assertDontSee('site_logo');
    }

    public function test_admin_can_upload_a_custom_logo(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs($this->admin())
            ->post(route('admin.settings.update-logo'), [
                'logo' => UploadedFile::fake()->image('logo.png'),
            ])
            ->assertRedirect(route('admin.settings.index', ['group' => 'general']));

        $value = (string) Setting::query()->where('key', 'site_logo')->value('value');

        $this->assertNotSame('', $value);
        Storage::disk('public_uploads')->assertExists($value);
    }

    public function test_uploading_a_new_logo_replaces_the_previous_file(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('branding/old.png', 'old-logo');

        Setting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => 'branding/old.png', 'type' => 'string', 'group' => 'general'],
        );

        $this->actingAs($this->admin())
            ->post(route('admin.settings.update-logo'), [
                'logo' => UploadedFile::fake()->image('new.png'),
            ])
            ->assertRedirect(route('admin.settings.index', ['group' => 'general']));

        $value = (string) Setting::query()->where('key', 'site_logo')->value('value');

        Storage::disk('public_uploads')->assertMissing('branding/old.png');
        Storage::disk('public_uploads')->assertExists($value);
        $this->assertNotSame('branding/old.png', $value);
    }

    public function test_admin_can_restore_the_default_logo(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('branding/custom.png', 'custom-logo');

        Setting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => 'branding/custom.png', 'type' => 'string', 'group' => 'general'],
        );

        $this->actingAs($this->admin())
            ->post(route('admin.settings.update-logo'), ['remove_logo' => '1'])
            ->assertRedirect(route('admin.settings.index', ['group' => 'general']));

        $this->assertSame('', (string) Setting::query()->where('key', 'site_logo')->value('value'));
        Storage::disk('public_uploads')->assertMissing('branding/custom.png');
    }

    public function test_the_logo_must_be_a_supported_image(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs($this->admin())
            ->post(route('admin.settings.update-logo'), [
                'logo' => UploadedFile::fake()->create('logo.pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHasErrors('logo');
    }

    public function test_non_admin_users_cannot_update_the_logo(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.settings.update-logo'), [
                'logo' => UploadedFile::fake()->image('logo.png'),
            ])
            ->assertForbidden();
    }

    public function test_a_custom_logo_is_used_on_the_public_site_and_in_admin(): void
    {
        Storage::fake('public_uploads');

        Setting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => 'branding/custom.png', 'type' => 'string', 'group' => 'general'],
        );

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('uploads/branding/custom.png', false);

        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('uploads/branding/custom.png', false);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
