<?php

namespace Tests\Feature\Admin;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\CustomTour;
use App\Models\Leader;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TermsSection;
use App\Models\TourReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_admin_resource_page_renders(): void
    {
        $admin = $this->admin();

        $leader = Leader::factory()->create();
        $report = TourReport::factory()->create();
        $customTour = CustomTour::factory()->create();
        $terms = TermsSection::factory()->create();
        $product = Product::factory()->create();
        $setting = Setting::factory()->create(['group' => 'contact']);

        $pages = [
            route('admin.leaders.index'),
            route('admin.leaders.create'),
            route('admin.leaders.edit', $leader),
            route('admin.tour-reports.index'),
            route('admin.tour-reports.create'),
            route('admin.tour-reports.edit', $report),
            route('admin.custom-tours.index'),
            route('admin.custom-tours.create'),
            route('admin.custom-tours.edit', $customTour),
            route('admin.terms-sections.index'),
            route('admin.terms-sections.create'),
            route('admin.terms-sections.edit', $terms),
            route('admin.products.index'),
            route('admin.products.create'),
            route('admin.products.edit', $product),
            route('admin.settings.index'),
            route('admin.settings.create'),
            route('admin.profile.show'),
        ];

        foreach ($pages as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }

        $this->assertDatabaseHas('settings', ['id' => $setting->id]);
    }

    public function test_the_inbox_detail_pages_render(): void
    {
        $admin = $this->admin();
        $booking = Booking::factory()->create();
        $message = ContactMessage::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.bookings.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.bookings.show', $booking))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.contact-messages.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.contact-messages.show', $message))
            ->assertOk();
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
