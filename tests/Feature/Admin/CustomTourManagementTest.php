<?php

namespace Tests\Feature\Admin;

use App\Models\CustomTour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomTourManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_custom_tours(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.custom-tours.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_custom_tour_listing(): void
    {
        $customTour = CustomTour::factory()->create(['title' => 'Sulawesi Endemics']);

        $this->actingAs($this->admin())
            ->get(route('admin.custom-tours.index'))
            ->assertOk()
            ->assertSee('Sulawesi Endemics')
            ->assertSee($customTour->slug);
    }

    public function test_admin_can_create_a_custom_tour(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.custom-tours.store'), [
                'title' => 'Sulawesi Endemics',
                'destination' => 'Sulawesi, Indonesia',
                'date_label' => 'Flexible, August 2027',
                'description' => 'A private tour focused on Sulawesi endemics.',
                'status' => 'open',
                'contact_email' => 'tours@example.com',
                'sort_order' => 3,
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.custom-tours.index'));

        $customTour = CustomTour::query()->where('slug', 'sulawesi-endemics')->firstOrFail();

        $this->assertSame('Sulawesi, Indonesia', $customTour->destination);
        $this->assertSame('Flexible, August 2027', $customTour->date_label);
        $this->assertSame('open', $customTour->status);
        $this->assertSame(3, $customTour->sort_order);
        $this->assertTrue($customTour->is_published);
    }

    public function test_custom_tour_slug_must_be_unique(): void
    {
        CustomTour::factory()->create(['slug' => 'sulawesi-endemics']);

        $this->actingAs($this->admin())
            ->post(route('admin.custom-tours.store'), [
                'title' => 'Sulawesi Endemics',
                'slug' => 'sulawesi-endemics',
                'status' => 'open',
            ])
            ->assertSessionHasErrors('slug');

        $this->assertSame(1, CustomTour::query()->count());
    }

    public function test_admin_can_update_a_custom_tour(): void
    {
        $customTour = CustomTour::factory()->create([
            'title' => 'Old Tour',
            'slug' => 'old-tour',
            'status' => 'open',
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.custom-tours.update', $customTour), [
                'title' => 'New Tour',
                'slug' => 'new-tour',
                'destination' => 'Papua',
                'status' => 'closed',
                'is_published' => '0',
            ])
            ->assertRedirect(route('admin.custom-tours.index'));

        $customTour->refresh();

        $this->assertSame('New Tour', $customTour->title);
        $this->assertSame('new-tour', $customTour->slug);
        $this->assertSame('Papua', $customTour->destination);
        $this->assertSame('closed', $customTour->status);
        $this->assertFalse($customTour->is_published);
    }

    public function test_admin_can_delete_a_custom_tour(): void
    {
        $customTour = CustomTour::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.custom-tours.destroy', $customTour))
            ->assertRedirect(route('admin.custom-tours.index'));

        $this->assertDatabaseMissing('custom_tours', ['id' => $customTour->id]);
    }

    public function test_the_listing_can_be_filtered_by_visibility(): void
    {
        CustomTour::factory()->create(['title' => 'Published Tour']);
        CustomTour::factory()->draft()->create(['title' => 'Draft Tour']);

        $this->actingAs($this->admin())
            ->get(route('admin.custom-tours.index', ['published' => '0']))
            ->assertOk()
            ->assertSee('Draft Tour')
            ->assertDontSee('Published Tour');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
