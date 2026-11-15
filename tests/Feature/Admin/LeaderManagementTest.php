<?php

namespace Tests\Feature\Admin;

use App\Models\Leader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeaderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get(route('admin.leaders.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_users_cannot_access_leaders(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.leaders.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_leader_listing(): void
    {
        $leader = Leader::factory()->create(['name' => 'Ding Li']);

        $this->actingAs($this->admin())
            ->get(route('admin.leaders.index'))
            ->assertOk()
            ->assertSee('Ding Li')
            ->assertSee($leader->slug);
    }

    public function test_admin_can_create_a_leader_with_an_uploaded_photo(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs($this->admin())
            ->post(route('admin.leaders.store'), [
                'name' => 'Ding Li',
                'region' => 'Yunnan, China',
                'bio' => 'Leading tours across southwest China for over a decade.',
                'email' => 'ding@example.com',
                'sort_order' => 2,
                'is_published' => '1',
                'photo_file' => UploadedFile::fake()->image('ding.jpg'),
            ])
            ->assertRedirect(route('admin.leaders.index'));

        $leader = Leader::query()->where('slug', 'ding-li')->firstOrFail();

        $this->assertSame('Ding Li', $leader->name);
        $this->assertSame('Yunnan, China', $leader->region);
        $this->assertTrue($leader->is_published);
        $this->assertSame(2, $leader->sort_order);
        $this->assertNotNull($leader->photo);
        Storage::disk('public_uploads')->assertExists($leader->photo);
    }

    public function test_leader_slug_must_be_unique(): void
    {
        Leader::factory()->create(['slug' => 'ding-li']);

        $this->actingAs($this->admin())
            ->post(route('admin.leaders.store'), [
                'name' => 'Ding Li',
                'slug' => 'ding-li',
            ])
            ->assertSessionHasErrors('slug');

        $this->assertSame(1, Leader::query()->count());
    }

    public function test_admin_can_update_a_leader(): void
    {
        $leader = Leader::factory()->create([
            'name' => 'Old Name',
            'slug' => 'old-name',
            'is_published' => true,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.leaders.update', $leader), [
                'name' => 'New Name',
                'slug' => 'new-name',
                'region' => 'Borneo',
                'is_published' => '0',
            ])
            ->assertRedirect(route('admin.leaders.index'));

        $leader->refresh();

        $this->assertSame('New Name', $leader->name);
        $this->assertSame('new-name', $leader->slug);
        $this->assertSame('Borneo', $leader->region);
        $this->assertFalse($leader->is_published);
    }

    public function test_updating_with_a_new_photo_replaces_the_old_file(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('leaders/old.jpg', 'old-image');

        $leader = Leader::factory()->create(['photo' => 'leaders/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.leaders.update', $leader), [
                'name' => $leader->name,
                'slug' => $leader->slug,
                'photo_file' => UploadedFile::fake()->image('new.jpg'),
            ])
            ->assertRedirect(route('admin.leaders.index'));

        $leader->refresh();

        Storage::disk('public_uploads')->assertMissing('leaders/old.jpg');
        Storage::disk('public_uploads')->assertExists($leader->photo);
        $this->assertNotSame('leaders/old.jpg', $leader->photo);
    }

    public function test_admin_can_remove_the_current_photo(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('leaders/old.jpg', 'old-image');

        $leader = Leader::factory()->create(['photo' => 'leaders/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.leaders.update', $leader), [
                'name' => $leader->name,
                'slug' => $leader->slug,
                'remove_image' => '1',
            ])
            ->assertRedirect(route('admin.leaders.index'));

        Storage::disk('public_uploads')->assertMissing('leaders/old.jpg');
        $this->assertNull($leader->refresh()->photo);
    }

    public function test_admin_can_delete_a_leader(): void
    {
        $leader = Leader::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.leaders.destroy', $leader))
            ->assertRedirect(route('admin.leaders.index'));

        $this->assertDatabaseMissing('leaders', ['id' => $leader->id]);
    }

    public function test_the_listing_can_be_filtered_by_visibility(): void
    {
        Leader::factory()->create(['name' => 'Published Leader']);
        Leader::factory()->draft()->create(['name' => 'Draft Leader']);

        $this->actingAs($this->admin())
            ->get(route('admin.leaders.index', ['published' => '0']))
            ->assertOk()
            ->assertSee('Draft Leader')
            ->assertDontSee('Published Leader');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
