<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use App\Models\Item;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_verification_email_is_sent()
    {
        Notification::fake();

        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        event(new Registered($user));

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_unverified_user_cannot_access_profile_page()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertRedirect('/email/verify');
    }

    public function test_verified_user_can_access_profile_page()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_mypage()
    {
        $response = $this->get('/mypage');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_post_comment()
    {
        $this->seed();

        $item = Item::first();

        $response = $this->post('/comment/' . $item->id, [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_like_item()
    {
        $this->seed();

        $item = Item::first();

        $response = $this->post('/like/' . $item->id);

        $response->assertRedirect('/login');
    }
}
