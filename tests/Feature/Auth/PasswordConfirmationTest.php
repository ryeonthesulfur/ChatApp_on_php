<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    // パスワード確認画面が正常に表示されるかテスト
    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    // 正しいパスワードで確認が通るかテスト
    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        // リダイレクトされるか確認
        $response->assertRedirect();
        // セッションにエラーがないか確認
        $response->assertSessionHasNoErrors();
    }

    // 間違ったパスワードでは確認が通らないかテスト
    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        // セッションにエラーがあるか確認
        $response->assertSessionHasErrors();
    }
}
