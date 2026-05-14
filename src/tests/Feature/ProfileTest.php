<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_sell_items_on_mypage()
    {
        $this->seed();

        $user = User::first();

        $response = $this->actingAs($user)->get('/mypage?my=sell');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }

    public function test_user_can_update_profile()
    {
        $this->seed();

        $user = User::first();

        $user->email_verified_at = now();
        $user->save();

        Profile::create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);

        $response = $this->actingAs($user)->put('/mypage/profile', [
            'name' => '新ユーザー',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);

        $response->assertRedirect('/mypage');

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

    public function test_user_can_post_comment()
    {
        $this->seed();

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
        $this->seed();

        $user = User::first();
        $item = Item::first();

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    public function test_user_can_like_item()
    {
        $this->seed();

        $user = User::first();
        $item = Item::first();

        $response = $this->actingAs($user)->post('/like/' . $item->id);

        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_can_unlike_item()
    {
        $this->seed();

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

    public function test_comment_cannot_exceed_255_characters()
    {
        $this->seed();

        $user = User::first();
        $item = Item::first();

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'content' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    public function test_user_cannot_like_same_item_twice()
    {
        $this->seed();

        $user = User::first();
        $item = Item::first();

        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)->post('/like/' . $item->id);

        $this->assertEquals(
            1,
            \App\Models\Like::where('user_id', $user->id)
                ->where('item_id', $item->id)
                ->count()
        );
    }
}
