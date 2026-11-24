<?php

namespace Tests\Feature\Admin;

use App\Enums\SitePage;
use App\Models\HeroSlide;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_page_settings(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.pages.show', SitePage::Booking))
            ->assertForbidden();
    }

    public function test_every_public_page_has_its_own_admin_settings_screen(): void
    {
        $this->seed(SettingSeeder::class);
        $admin = $this->admin();

        foreach (SitePage::cases() as $page) {
            $this->actingAs($admin)
                ->get(route('admin.pages.show', $page))
                ->assertOk()
                ->assertSee($page->label());
        }
    }

    public function test_page_settings_show_only_that_pages_slides_and_settings(): void
    {
        $this->seed(SettingSeeder::class);

        HeroSlide::factory()->create(['page' => 'booking', 'alt' => 'Booking only slide']);
        HeroSlide::factory()->create(['page' => 'home', 'alt' => 'Home only slide']);

        $this->actingAs($this->admin())
            ->get(route('admin.pages.show', SitePage::Booking))
            ->assertOk()
            ->assertSee('booking_hero_title')
            ->assertSee('Booking only slide')
            ->assertDontSee('Home only slide')
            ->assertDontSee('home_announcement_title');
    }

    public function test_updating_page_settings_changes_only_that_pages_values(): void
    {
        $this->seed(SettingSeeder::class);

        $title = Setting::query()->where('key', 'booking_hero_title')->firstOrFail();
        $homeTitle = Setting::query()->where('key', 'home_announcement_title')->firstOrFail();

        $this->actingAs($this->admin())
            ->put(route('admin.pages.update', SitePage::Booking), [
                'values' => [
                    $title->id => 'Reserved for this page',
                    $homeTitle->id => 'Should not change',
                ],
            ])
            ->assertRedirect(route('admin.pages.show', SitePage::Booking));

        $this->assertSame('Reserved for this page', $title->fresh()->value);
        $this->assertSame('Latest news 14/10', $homeTitle->fresh()->value);
    }

    public function test_page_hero_text_is_used_only_by_its_public_page(): void
    {
        $this->seed(SettingSeeder::class);

        Setting::query()->where('key', 'contact_hero_title')->firstOrFail()->update([
            'value' => 'Ask the team directly',
        ]);

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Ask the team directly');

        $this->get(route('booking'))
            ->assertOk()
            ->assertDontSee('Ask the team directly');
    }

    public function test_a_slide_created_from_page_settings_returns_to_that_page(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.hero-slides.store'), [
                'page' => 'booking',
                'return_page' => 'booking',
                'alt' => 'Booking hero from page settings',
                'image' => 'https://cdn.example.com/booking.jpg',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.pages.show', SitePage::Booking));

        $this->assertDatabaseHas('hero_slides', [
            'page' => 'booking',
            'alt' => 'Booking hero from page settings',
        ]);
    }

    public function test_create_form_preselects_the_page_being_configured(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.hero-slides.create', ['page' => 'booking']))
            ->assertOk()
            ->assertSee('name="return_page" value="booking"', false)
            ->assertSee('value="booking"', false);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
