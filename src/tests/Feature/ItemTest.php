<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_top_page_can_be_displayed()
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_items_are_displayed_on_top_page()
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }

    public function test_item_detail_page_can_be_displayed()
    {
        $this->seed();

        $item = Item::where('name', '腕時計')->first();

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }

    public function test_logged_in_user_can_create_item()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'price' => 3000,
        ]);
    }

    public function test_item_name_is_required()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => '',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_image_is_required()
    {
        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'condition' => 1,
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['image']);
    }

    public function test_price_is_required()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'description' => 'テスト説明',
            'price' => '',
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_description_is_required()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'description' => '',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['description']);
    }

    public function test_condition_is_required()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => '',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['condition']);
    }

    public function test_categories_are_required()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => [],
        ]);

        $response->assertSessionHasErrors(['categories']);
    }

    public function test_user_can_search_items()
    {
        $this->seed();

        $response = $this->get('/?keyword=腕時計');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }

    public function test_price_must_be_numeric()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 'abc',
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_image_must_be_png_or_jpeg()
    {
        Storage::fake('public');

        $this->seed();

        $user = User::first();
        $categoryIds = Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.pdf', 100, 'application/pdf'),
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['image']);
    }
}
