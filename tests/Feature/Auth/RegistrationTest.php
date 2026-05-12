<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    // テストごとにDBをリセットする（テスト間でデータが干渉しないようにする）
    use RefreshDatabase;

    // 新規登録画面が正常に表示されるかテスト（HTTPステータス200が返るか）
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    // 正しい情報を送信して新規登録できるかテスト
    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // 登録後にログイン済み状態になっているか確認
        $this->assertAuthenticated();
        // ダッシュボードにリダイレクトされるか確認
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
