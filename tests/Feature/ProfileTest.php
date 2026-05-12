<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // プロフィール画面が正常に表示されるかテスト
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    // 名前とメールアドレスを更新できるかテスト
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        // 名前が更新されているか確認
        $this->assertSame('Test User', $user->name);
        // メールアドレスが更新されているか確認
        $this->assertSame('test@example.com', $user->email);
        // メールアドレスを変更したのでメール認証がリセットされているか確認
        $this->assertNull($user->email_verified_at);
    }

    // メールアドレスを変更しない場合、認証済み状態が維持されるかテスト
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email, // メールアドレスは変えない
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        // 認証済み状態が維持されているか確認
        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    // 正しいパスワードでアカウントを削除できるかテスト
    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        // ログアウト状態になっているか確認
        $this->assertGuest();
        // DBからユーザーが削除されているか確認
        $this->assertNull($user->fresh());
    }

    // 間違ったパスワードではアカウントを削除できないかテスト
    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password', // 意図的に間違ったパスワード
            ]);

        // passwordのエラーがセッションにあるか確認
        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        // ユーザーがDBに残っているか確認
        $this->assertNotNull($user->fresh());
    }
}
