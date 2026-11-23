<?php

namespace Tests\Feature\Admin;

use App\Enums\TourStatus;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TourManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get(route('admin.tours.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_users_cannot_access_tours(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.tours.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_tour_listing(): void
    {
        $tour = Tour::factory()->create(['name' => 'Borneo Rainforest Special']);

        $this->actingAs($this->admin())
            ->get(route('admin.tours.index'))
            ->assertOk()
            ->assertSee('Borneo Rainforest Special')
            ->assertSee($tour->slug)
            ->assertSee('View all')
            ->assertSee('data-modal-url="'.route('admin.tours.show', $tour).'"', false);
    }

    public function test_admin_can_fetch_tour_details_for_the_modal(): void
    {
        $tour = Tour::factory()->create([
            'name' => 'Borneo Rainforest Special',
            'slug' => 'borneo-rainforest-special',
            'summary' => 'A dedicated Borneo itinerary.',
            'description' => 'Ten days in the rainforest.',
            'itinerary' => "Day 1: Arrival\nDay 2: Rainforest",
            'price_gbp' => 123456,
        ]);

        $this->actingAs($this->admin())
            ->get(route('admin.tours.show', $tour))
            ->assertOk()
            ->assertSee('Borneo Rainforest Special')
            ->assertSee('borneo-rainforest-special')
            ->assertSee('A dedicated Borneo itinerary.')
            ->assertSee('Ten days in the rainforest.')
            ->assertSee('Day 2: Rainforest')
            ->assertSee('£1,234.56');
    }

    public function test_non_admin_users_cannot_fetch_tour_details(): void
    {
        $tour = Tour::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('admin.tours.show', $tour))
            ->assertForbidden();
    }

    public function test_create_page_renders_the_five_step_wizard(): void
    {
        $response = $this->actingAs($this->admin())
            ->get(route('admin.tours.create'))
            ->assertOk()
            ->assertSee('data-wizard', false)
            ->assertSee('Step 1 of 5');

        foreach (['Basic info', 'Content', 'Dates & pricing', 'Media', 'Publishing & SEO'] as $step) {
            $response->assertSee($step);
        }
    }

    public function test_admin_can_create_a_tour_with_an_uploaded_image(): void
    {
        Storage::fake('public_uploads');

        $response = $this->actingAs($this->admin())
            ->post(route('admin.tours.store'), [
                'name' => 'China in Winter',
                'slug' => 'china-in-winter',
                'year' => 2027,
                'country' => 'China',
                'summary' => 'Winter birding across central China.',
                'duration_days' => 20,
                'group_size' => '7-8',
                'status' => TourStatus::Available->value,
                'status_label' => 'Only two places left',
                'price_gbp' => '3495.00',
                'price_usd' => '4295.00',
                'is_published' => '1',
                'image_file' => UploadedFile::fake()->image('china.jpg'),
            ]);

        $response->assertRedirect(route('admin.tours.index'));

        $tour = Tour::query()->where('slug', 'china-in-winter')->firstOrFail();

        $this->assertSame(349500, $tour->price_gbp);
        $this->assertSame(429500, $tour->price_usd);
        $this->assertSame('7-8', $tour->group_size);
        $this->assertTrue($tour->is_published);
        $this->assertSame('Only two places left', $tour->statusLabel());

        Storage::disk('public_uploads')->assertExists($tour->image);
    }

    public function test_slug_must_be_unique_when_creating_a_tour(): void
    {
        Tour::factory()->create(['slug' => 'borneo-rainforest']);

        $this->actingAs($this->admin())
            ->post(route('admin.tours.store'), [
                'name' => 'Borneo Rainforest',
                'slug' => 'borneo-rainforest',
                'year' => 2027,
                'status' => TourStatus::Available->value,
            ])
            ->assertSessionHasErrors('slug');

        $this->assertSame(1, Tour::query()->count());
    }

    public function test_admin_can_update_a_tour(): void
    {
        $tour = Tour::factory()->create([
            'name' => 'Old tour name',
            'slug' => 'old-tour-name',
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.tours.update', $tour), [
                'name' => 'New tour name',
                'slug' => 'new-tour-name',
                'year' => 2028,
                'status' => TourStatus::Full->value,
                'status_label' => 'Waiting list only',
                'price_gbp' => '1999.50',
                'is_published' => '0',
            ])
            ->assertRedirect(route('admin.tours.index'));

        $tour->refresh();

        $this->assertSame('New tour name', $tour->name);
        $this->assertSame('new-tour-name', $tour->slug);
        $this->assertSame(2028, $tour->year);
        $this->assertSame(TourStatus::Full, $tour->status);
        $this->assertSame('Waiting list only', $tour->statusLabel());
        $this->assertSame(199950, $tour->price_gbp);
        $this->assertFalse($tour->is_published);
    }

    public function test_updating_with_a_new_image_replaces_the_old_file(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('tours/old.jpg', 'old-image');

        $tour = Tour::factory()->create(['image' => 'tours/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.tours.update', $tour), [
                'name' => $tour->name,
                'slug' => $tour->slug,
                'year' => $tour->year,
                'status' => $tour->status->value,
                'image_file' => UploadedFile::fake()->image('new.jpg'),
            ])
            ->assertRedirect(route('admin.tours.index'));

        $tour->refresh();

        Storage::disk('public_uploads')->assertMissing('tours/old.jpg');
        Storage::disk('public_uploads')->assertExists($tour->image);
        $this->assertNotSame('tours/old.jpg', $tour->image);
    }

    public function test_admin_can_remove_the_current_image(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('tours/old.jpg', 'old-image');

        $tour = Tour::factory()->create(['image' => 'tours/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.tours.update', $tour), [
                'name' => $tour->name,
                'slug' => $tour->slug,
                'year' => $tour->year,
                'status' => $tour->status->value,
                'remove_image' => '1',
            ])
            ->assertRedirect(route('admin.tours.index'));

        Storage::disk('public_uploads')->assertMissing('tours/old.jpg');
        $this->assertNull($tour->refresh()->image);
    }

    public function test_admin_can_soft_delete_a_tour(): void
    {
        $tour = Tour::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.tours.destroy', $tour))
            ->assertRedirect(route('admin.tours.index'));

        $this->assertSoftDeleted($tour);
    }

    public function test_the_listing_can_be_filtered_by_publication_visibility(): void
    {
        Tour::factory()->create(['name' => 'Published Departure']);
        Tour::factory()->draft()->create(['name' => 'Draft Departure']);

        $this->actingAs($this->admin())
            ->get(route('admin.tours.index', ['published' => '0']))
            ->assertOk()
            ->assertSee('Draft Departure')
            ->assertDontSee('Published Departure');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
