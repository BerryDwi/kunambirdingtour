<?php

namespace Tests\Feature\Admin;

use App\Enums\Currency;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_products(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_product_listing(): void
    {
        Product::factory()->create(['name' => 'Field Notebook']);

        $this->actingAs($this->admin())
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Field Notebook');
    }

    public function test_admin_can_create_a_product_with_a_price_in_major_units(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs($this->admin())
            ->post(route('admin.products.store'), [
                'name' => 'Field Notebook',
                'description' => 'A waterproof notebook for birders.',
                'price' => '24.99',
                'currency' => Currency::Gbp->value,
                'purchase_url' => 'https://example.com/shop/notebook',
                'is_active' => '1',
                'image_file' => UploadedFile::fake()->image('notebook.jpg'),
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::query()->where('slug', 'field-notebook')->firstOrFail();

        $this->assertSame(2499, $product->price);
        $this->assertSame(Currency::Gbp, $product->currency);
        $this->assertTrue($product->is_active);
        $this->assertNotNull($product->image);
        Storage::disk('public_uploads')->assertExists($product->image);
    }

    public function test_currency_is_required_when_creating_a_product(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.products.store'), [
                'name' => 'Field Notebook',
                'price' => '10.00',
            ])
            ->assertSessionHasErrors('currency');
    }

    public function test_admin_can_update_a_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Old Product',
            'slug' => 'old-product',
            'price' => 1000,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.products.update', $product), [
                'name' => 'New Product',
                'slug' => 'new-product',
                'price' => '15.50',
                'currency' => Currency::Usd->value,
                'is_active' => '0',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product->refresh();

        $this->assertSame('New Product', $product->name);
        $this->assertSame('new-product', $product->slug);
        $this->assertSame(1550, $product->price);
        $this->assertSame(Currency::Usd, $product->currency);
        $this->assertFalse($product->is_active);
    }

    public function test_updating_with_a_new_image_replaces_the_old_file(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('products/old.jpg', 'old-image');

        $product = Product::factory()->create(['image' => 'products/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.products.update', $product), [
                'name' => $product->name,
                'slug' => $product->slug,
                'currency' => Currency::Gbp->value,
                'image_file' => UploadedFile::fake()->image('new.jpg'),
            ])
            ->assertRedirect(route('admin.products.index'));

        Storage::disk('public_uploads')->assertMissing('products/old.jpg');
        Storage::disk('public_uploads')->assertExists($product->refresh()->image);
    }

    public function test_admin_can_remove_the_current_image(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('products/old.jpg', 'old-image');

        $product = Product::factory()->create(['image' => 'products/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.products.update', $product), [
                'name' => $product->name,
                'slug' => $product->slug,
                'currency' => Currency::Gbp->value,
                'remove_image' => '1',
            ])
            ->assertRedirect(route('admin.products.index'));

        Storage::disk('public_uploads')->assertMissing('products/old.jpg');
        $this->assertNull($product->refresh()->image);
    }

    public function test_admin_can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_the_listing_can_be_filtered_by_availability(): void
    {
        Product::factory()->create(['name' => 'Active Product']);
        Product::factory()->inactive()->create(['name' => 'Inactive Product']);

        $this->actingAs($this->admin())
            ->get(route('admin.products.index', ['active' => '0']))
            ->assertOk()
            ->assertSee('Inactive Product')
            ->assertDontSee('Active Product');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
