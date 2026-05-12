<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    // テストごとにDBをリセットする（テスト間でデータが干渉しないようにする）
    use RefreshDatabase;

    // ログイン画面が正常に表示されるかテスト（HTTPステータス200が返るか）
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    // 正しいメールアドレスとパスワードでログインできるかテスト
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        // ファクトリでテスト用ユーザーをDBに作成
        $user = User::factory()->create();

        // 作成したユーザーの情報でログインリクエストを送信
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // ファクトリのデフォルトパスワード
        ]);

        // ログイン済み状態になっているか確認
        $this->assertAuthenticated();
        // ダッシュボードにリダイレクトされるか確認
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    // 間違ったパスワードではログインできないかテスト
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password', // 意図的に間違ったパスワード
        ]);

        // 未ログイン状態のままであるか確認
        $this->assertGuest();
    }

    // ログアウトできるかテスト
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        // ログイン済み状態としてログアウトリクエストを送信
        $response = $this->actingAs($user)->post('/logout');

        // 未ログイン状態になっているか確認
        $this->assertGuest();
        // トップページにリダイレクトされるか確認
        $response->assertRedirect('/');
    }
}
