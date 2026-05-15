<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_purchase_item_by_konbini()
    {
        $this->seed();

        $item = Item::where('name', '腕時計')->first();

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer_konbini@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
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

    public function test_logged_in_user_can_purchase_item_by_card()
    {
        $this->seed();

        $item = Item::where('name', '腕時計')->first();

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer_card@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 2,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 2,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $this->assertNotNull($item->fresh()->sold_at);
    }

    public function test_owner_cannot_purchase_own_item()
    {
        $this->seed();

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
        $this->seed();

        $item = Item::where('name', '腕時計')->first();
        $item->update(['sold_at' => now()]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer_sold@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
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
        $this->seed();

        $item = Item::where('name', '腕時計')->first();

        $response = $this->get('/purchase/' . $item->id);

        $response->assertRedirect('/login');
    }

    public function test_user_can_update_purchase_address()
    {
        $this->seed();

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

    public function test_user_can_view_purchase_items_on_mypage()
    {
        $this->seed();

        $seller = User::first();
        $item = Item::where('user_id', $seller->id)->first();

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer_mypage@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $buyer->id,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        Purchase::create([
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
}
