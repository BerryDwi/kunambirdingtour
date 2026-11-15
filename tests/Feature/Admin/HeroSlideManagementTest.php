<?php

namespace Tests\Feature\Admin;

use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroSlideManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_hero_slides(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.hero-slides.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_hero_slide_listing(): void
    {
        HeroSlide::factory()->create([
            'page' => 'home',
            'alt' => 'Oriental Plover',
        ]);

        $this->actingAs($this->admin())
            ->get(route('admin.hero-slides.index'))
            ->assertOk()
            ->assertSee('Oriental Plover')
            ->assertSee('Home');
    }

    public function test_admin_can_create_a_slide_with_an_uploaded_image(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs($this->admin())
            ->post(route('admin.hero-slides.store'), [
                'page' => 'tours',
                'alt' => 'Scheduled tours hero',
                'title' => 'Scheduled Tours',
                'text' => 'Explore our calendar.',
                'sort_order' => 1,
                'is_active' => '1',
                'image_file' => UploadedFile::fake()->image('hero.jpg'),
            ])
            ->assertRedirect(route('admin.hero-slides.index'));

        $slide = HeroSlide::query()->where('alt', 'Scheduled tours hero')->firstOrFail();

        $this->assertSame('tours', $slide->page);
        $this->assertSame('Scheduled Tours', $slide->title);
        $this->assertTrue($slide->is_active);
        $this->assertSame(1, $slide->sort_order);
        Storage::disk('public_uploads')->assertExists($slide->image);
    }

    public function test_admin_can_create_a_slide_with_an_external_image_url(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.hero-slides.store'), [
                'page' => 'leaders',
                'alt' => 'Leaders hero',
                'image' => 'https://cdn.example.com/leaders.jpg',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.hero-slides.index'));

        $this->assertDatabaseHas('hero_slides', [
            'page' => 'leaders',
            'image' => 'https://cdn.example.com/leaders.jpg',
            'is_active' => true,
        ]);
    }

    public function test_a_slide_requires_an_image_when_created(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.hero-slides.store'), [
                'page' => 'home',
                'alt' => 'No image',
            ])
            ->assertSessionHasErrors('image_file');

        $this->assertSame(0, HeroSlide::query()->count());
    }

    public function test_admin_can_update_a_slide(): void
    {
        $slide = HeroSlide::factory()->create([
            'page' => 'home',
            'title' => 'Old title',
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.hero-slides.update', $slide), [
                'page' => 'contact',
                'alt' => 'Contact hero',
                'title' => 'New title',
                'is_active' => '0',
            ])
            ->assertRedirect(route('admin.hero-slides.index'));

        $slide->refresh();

        $this->assertSame('contact', $slide->page);
        $this->assertSame('New title', $slide->title);
        $this->assertFalse($slide->is_active);
    }

    public function test_updating_with_a_new_image_replaces_the_old_file(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('hero-slides/old.jpg', 'old-image');

        $slide = HeroSlide::factory()->create(['image' => 'hero-slides/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.hero-slides.update', $slide), [
                'page' => $slide->page,
                'image_file' => UploadedFile::fake()->image('new.jpg'),
            ])
            ->assertRedirect(route('admin.hero-slides.index'));

        $slide->refresh();

        Storage::disk('public_uploads')->assertMissing('hero-slides/old.jpg');
        Storage::disk('public_uploads')->assertExists($slide->image);
        $this->assertNotSame('hero-slides/old.jpg', $slide->image);
    }

    public function test_admin_can_remove_the_current_image_only_with_a_replacement(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('hero-slides/old.jpg', 'old-image');

        $slide = HeroSlide::factory()->create(['image' => 'hero-slides/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.hero-slides.update', $slide), [
                'page' => $slide->page,
                'remove_image' => '1',
            ])
            ->assertSessionHasErrors('image_file');

        Storage::disk('public_uploads')->assertExists('hero-slides/old.jpg');
    }

    public function test_admin_can_delete_a_slide(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('hero-slides/old.jpg', 'old-image');

        $slide = HeroSlide::factory()->create(['image' => 'hero-slides/old.jpg']);

        $this->actingAs($this->admin())
            ->delete(route('admin.hero-slides.destroy', $slide))
            ->assertRedirect(route('admin.hero-slides.index'));

        $this->assertDatabaseMissing('hero_slides', ['id' => $slide->id]);
        Storage::disk('public_uploads')->assertMissing('hero-slides/old.jpg');
    }

    public function test_the_listing_can_be_filtered_by_page(): void
    {
        HeroSlide::factory()->create(['page' => 'home', 'alt' => 'Home slide']);
        HeroSlide::factory()->create(['page' => 'tours', 'alt' => 'Tours slide']);

        $this->actingAs($this->admin())
            ->get(route('admin.hero-slides.index', ['hero_page' => 'tours']))
            ->assertOk()
            ->assertSee('Tours slide')
            ->assertDontSee('Home slide');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
