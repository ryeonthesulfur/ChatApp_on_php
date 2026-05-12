<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    // 正しい現在のパスワードを入力してパスワードを変更できるかテスト
    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        // エラーなしでプロフィール画面にリダイレクトされるか確認
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        // DBのパスワードが新しいものに変わっているか確認
        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    // 間違った現在のパスワードではパスワード変更できないかテスト
    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password', // 意図的に間違ったパスワード
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        // current_passwordのエラーがセッションにあるか確認
        $response
            ->assertSessionHasErrors('current_password')
            ->assertRedirect('/profile');
    }
}
