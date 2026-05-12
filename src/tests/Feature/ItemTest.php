<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
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
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_items_are_displayed_on_top_page()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }

    public function test_item_detail_page_can_be_displayed()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $item = Item::where('name', '腕時計')->first();

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }

    public function test_guest_user_cannot_access_sell_page()
    {
        $response = $this->get('/sell');

        $response->assertRedirect('/login');
    }

    public function test_logged_in_user_can_create_item()
    {
        Storage::fake('public');

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $categoryIds = \App\Models\Category::pluck('id')->take(2)->toArray();

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

    public function test_logged_in_user_can_purchase_item()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $item = Item::where('name', '腕時計')->first();

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
            'name' => $buyer->name,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 1,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $this->assertNotNull($item->fresh()->sold_at);
    }

    public function test_item_name_is_required()
    {
        Storage::fake('public');

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => '',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => [1, 2],
        ]);

        $response->assertSessionHasErrors(['name']);
    }
    public function test_image_is_required()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $categoryIds = \App\Models\Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['image']);
    }

    public function test_price_is_required()
    {
        Storage::fake('public');

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $categoryIds = \App\Models\Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => '',
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_description_is_required()
    {
        Storage::fake('public');

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $categoryIds = \App\Models\Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => '',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['description']);
    }

    public function test_condition_is_required()
    {
        Storage::fake('public');

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $categoryIds = \App\Models\Category::pluck('id')->take(2)->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => '',
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => $categoryIds,
        ]);

        $response->assertSessionHasErrors(['condition']);
    }

    public function test_categories_are_required()
    {
        Storage::fake('public');

        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('item.jpg', 100, 'image/jpeg'),
            'name' => 'テスト商品',
            'condition' => 1,
            'brand_name' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 3000,
            'categories' => [],
        ]);

        $response->assertSessionHasErrors(['categories']);
    }

    public function test_owner_cannot_purchase_own_item()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $owner = User::first();

        $item = Item::where('user_id', $owner->id)->first();

        $response = $this->actingAs($owner)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseMissing('purchases', [
            'item_id' => $item->id,
        ]);
    }

    public function test_sold_item_cannot_be_purchased()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $item = Item::where('name', '腕時計')->first();

        $item->update([
            'sold_at' => now(),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer2@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
            'name' => $buyer->name,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 1,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseMissing('purchases', [
            'item_id' => $item->id,
        ]);
    }

    public function test_guest_cannot_access_purchase_page()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $item = Item::where('name', '腕時計')->first();

        $response = $this->get('/purchase/' . $item->id);

        $response->assertRedirect('/login');
    }

    public function test_user_can_view_sell_items_on_mypage()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $response = $this->actingAs($user)->get('/mypage?my=sell');

        $response->assertStatus(200);

        $response->assertSee('腕時計');
    }

    public function test_user_can_view_purchase_items_on_mypage()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $seller = User::first();

        $item = Item::where('user_id', $seller->id)->first();

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer3@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
            'name' => $buyer->name,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        \App\Models\Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 1,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?my=buy');

        $response->assertStatus(200);

        $response->assertSee($item->name);
    }

    public function test_user_can_post_comment()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $item = Item::first();

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'content' => 'テストコメント',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_comment_is_required()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $item = Item::first();

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    public function test_user_can_like_item()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $item = Item::first();

        $response = $this->actingAs($user)->post('/like/' . $item->id);

        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_can_update_profile()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        Profile::create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);

        Storage::fake('public');

        $response = $this->actingAs($user)->put('/mypage/profile', [
            'name' => '新ユーザー',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新ユーザー',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);
    }

    public function test_user_can_update_purchase_address()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        Profile::create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);

        $item = Item::first();

        $response = $this->actingAs($user)->put('/purchase/address/' . $item->id, [
            'post_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => '新ビル',
        ]);

        $response->assertRedirect('/purchase/' . $item->id);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => '新ビル',
        ]);
    }

    public function test_user_can_unlike_item()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::first();

        $item = Item::first();

        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete('/like/' . $item->id);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_can_search_items()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $response = $this->get('/?keyword=腕時計');

        $response->assertStatus(200);

        $response->assertSee('腕時計');

        $response->assertDontSee('HDD');
    }
}
