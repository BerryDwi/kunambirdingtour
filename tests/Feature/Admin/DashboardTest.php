<?php

namespace Tests\Feature\Admin;

use App\Enums\TourStatus;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_content_statistics_and_charts(): void
    {
        $admin = $this->admin();

        Tour::factory()->create(['status' => TourStatus::Available, 'is_published' => true]);
        Tour::factory()->count(2)->create(['status' => TourStatus::Full, 'is_published' => true]);
        Tour::factory()->create(['status' => TourStatus::Provisional, 'is_published' => false]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Tours per year');
        $response->assertSee('Inbox activity');
        $response->assertSee('New tours');
        $response->assertSee('Tour status');
        $response->assertSee('id="tours-by-year-chart"', false);
        $response->assertSee('id="inbox-trend-chart"', false);
        $response->assertSee('id="tour-status-chart"', false);

        $stats = collect($response->viewData('stats'))->keyBy('label');

        $this->assertSame(3, $stats['Tours']['value']);
        $this->assertSame('4 total', $stats['Tours']['note']);

        $this->assertSame(
            ['Available', 'Tour is full', 'Tour provisionally full'],
            $response->viewData('tourStatus')['labels'],
        );
        $this->assertSame([1, 2, 0], $response->viewData('tourStatus')['values']);
    }

    public function test_dashboard_groups_published_tours_by_year(): void
    {
        $admin = $this->admin();

        Tour::factory()->create(['year' => 2027]);
        Tour::factory()->count(2)->create(['year' => 2028]);
        Tour::factory()->draft()->create(['year' => 2029]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();

        $this->assertSame(['2027', '2028'], $response->viewData('toursByYear')['labels']);
        $this->assertSame([1, 2], $response->viewData('toursByYear')['values']);
    }

    public function test_dashboard_lists_only_the_five_closest_upcoming_tours(): void
    {
        $admin = $this->admin();

        foreach (range(1, 6) as $index) {
            Tour::factory()->create([
                'name' => 'Upcoming Tour '.$index,
                'year' => 2027,
                'start_date' => now()->addDays(10 + $index),
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Upcoming Tour 1');
        $response->assertSee('Upcoming Tour 5');
        $response->assertDontSee('Upcoming Tour 6');
    }

    public function test_dashboard_counts_bookings_and_messages_in_the_inbox_trend(): void
    {
        $admin = $this->admin();

        $booking = Booking::factory()->create();

        $booking->forceFill(['created_at' => now()->subMonths(2)])->save();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();

        $trend = $response->viewData('inboxTrend');

        $this->assertCount(6, $trend['labels']);
        $this->assertSame(1, array_sum($trend['bookings']));
        $this->assertSame(0, array_sum($trend['messages']));
    }

    public function test_dashboard_renders_without_any_content(): void
    {
        $response = $this->actingAs($this->admin())->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('No upcoming tours yet.');
    }

    public function test_non_admin_users_cannot_access_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
