<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_settings(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.settings.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_settings_grouped_by_area(): void
    {
        Setting::factory()->create([
            'key' => 'contact_email',
            'value' => 'hello@example.com',
            'group' => 'contact',
        ]);

        $this->actingAs($this->admin())
            ->get(route('admin.settings.index'))
            ->assertOk()
            ->assertSee('contact_email')
            ->assertSee('hello@example.com')
            ->assertSee('Contact');
    }

    public function test_settings_page_shows_only_the_active_group(): void
    {
        Setting::factory()->create([
            'key' => 'site_name',
            'value' => 'General Value',
            'group' => 'general',
        ]);
        Setting::factory()->create([
            'key' => 'meta_title',
            'value' => 'SEO Value',
            'group' => 'seo',
        ]);

        $response = $this->actingAs($this->admin())
            ->get(route('admin.settings.index'));

        $response->assertOk()
            ->assertSee('General')
            ->assertSee('site_name')
            ->assertSee('General Value')
            ->assertDontSee('meta_title')
            ->assertDontSee('SEO Value');

        $response = $this->actingAs($this->admin())
            ->get(route('admin.settings.index', ['group' => 'seo']));

        $response->assertOk()
            ->assertSee('meta_title')
            ->assertSee('SEO Value')
            ->assertDontSee('site_name')
            ->assertDontSee('General Value');
    }

    public function test_settings_page_falls_back_to_the_first_group_for_an_unknown_group(): void
    {
        Setting::factory()->create([
            'key' => 'site_name',
            'value' => 'General Value',
            'group' => 'general',
        ]);
        Setting::factory()->create([
            'key' => 'meta_title',
            'value' => 'SEO Value',
            'group' => 'seo',
        ]);

        $response = $this->actingAs($this->admin())
            ->get(route('admin.settings.index', ['group' => 'missing']));

        $response->assertOk()
            ->assertSee('site_name')
            ->assertDontSee('meta_title');
    }

    public function test_admin_can_create_a_setting(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.settings.store'), [
                'key' => 'contact_phone',
                'value' => '+44 1234 567890',
                'type' => 'string',
                'group' => 'contact',
            ])
            ->assertRedirect(route('admin.settings.index', ['group' => 'contact']));

        $setting = Setting::query()->where('key', 'contact_phone')->firstOrFail();

        $this->assertSame('+44 1234 567890', $setting->value);
        $this->assertSame('contact', $setting->group);
    }

    public function test_the_create_form_is_scoped_to_the_active_group(): void
    {
        Setting::factory()->create(['key' => 'site_name', 'group' => 'general']);
        Setting::factory()->create(['key' => 'meta_title', 'group' => 'seo']);

        $response = $this->actingAs($this->admin())
            ->get(route('admin.settings.create', ['group' => 'seo']));

        $response->assertOk()
            ->assertSee('Add setting to SEO')
            ->assertSee('name="group" value="seo"', false)
            ->assertDontSee('id="group"', false);
    }

    public function test_the_create_form_falls_back_to_the_first_group(): void
    {
        Setting::factory()->create(['key' => 'site_name', 'group' => 'general']);
        Setting::factory()->create(['key' => 'meta_title', 'group' => 'seo']);

        $this->actingAs($this->admin())
            ->get(route('admin.settings.create', ['group' => 'missing']))
            ->assertOk()
            ->assertSee('name="group" value="general"', false);
    }

    public function test_the_add_setting_button_is_scoped_to_the_active_group_card(): void
    {
        Setting::factory()->create(['key' => 'site_name', 'group' => 'general']);
        Setting::factory()->create(['key' => 'meta_title', 'group' => 'seo']);

        $this->actingAs($this->admin())
            ->get(route('admin.settings.index', ['group' => 'seo']))
            ->assertOk()
            ->assertSee(route('admin.settings.create', ['group' => 'seo']), false);
    }

    public function test_setting_keys_must_be_unique(): void
    {
        Setting::factory()->create(['key' => 'contact_email']);

        $this->actingAs($this->admin())
            ->post(route('admin.settings.store'), [
                'key' => 'contact_email',
                'type' => 'string',
                'group' => 'contact',
            ])
            ->assertSessionHasErrors('key');
    }

    public function test_admin_can_bulk_update_every_setting_in_a_group(): void
    {
        $email = Setting::factory()->create([
            'key' => 'contact_email',
            'value' => 'old@example.com',
            'group' => 'contact',
        ]);
        $phone = Setting::factory()->create([
            'key' => 'contact_phone',
            'value' => '000',
            'group' => 'contact',
        ]);
        $other = Setting::factory()->create([
            'key' => 'facebook_url',
            'value' => 'https://facebook.com/old',
            'group' => 'social',
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.settings.update-group', 'contact'), [
                'values' => [
                    $email->id => 'new@example.com',
                    $phone->id => '+44 999',
                ],
            ])
            ->assertRedirect(route('admin.settings.index', ['group' => 'contact']));

        $this->assertSame('new@example.com', $email->refresh()->value);
        $this->assertSame('+44 999', $phone->refresh()->value);
        $this->assertSame('https://facebook.com/old', $other->refresh()->value);
    }

    public function test_bulk_update_requires_values(): void
    {
        Setting::factory()->create(['group' => 'contact']);

        $this->actingAs($this->admin())
            ->put(route('admin.settings.update-group', 'contact'), [])
            ->assertSessionHasErrors('values');
    }

    public function test_admin_can_delete_a_setting(): void
    {
        $setting = Setting::factory()->create(['group' => 'contact']);

        $this->actingAs($this->admin())
            ->delete(route('admin.settings.destroy', $setting))
            ->assertRedirect(route('admin.settings.index', ['group' => 'contact']));

        $this->assertDatabaseMissing('settings', ['id' => $setting->id]);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
