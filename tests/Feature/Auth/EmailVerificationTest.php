<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    // メール認証画面が正常に表示されるかテスト（未認証ユーザーでアクセス）
    public function test_email_verification_screen_can_be_rendered(): void
    {
        // 未認証状態のユーザーをファクトリで作成
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    // 正しい認証URLでメール認証が完了するかテスト
    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();

        // イベントの発火を監視（実際にメールを送らないようにする）
        Event::fake();

        // 有効な署名付き認証URLを生成（60分有効）
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        // Verifiedイベントが発火されたか確認
        Event::assertDispatched(Verified::class);
        // ユーザーが認証済みになったか確認
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        // ルーム一覧にリダイレクトされるか確認
        $response->assertRedirect(route('rooms.index', absolute: false));
    }

    // 不正なハッシュでは認証できないかテスト
    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        // 意図的に間違ったメールのハッシュで認証URLを生成
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        // 認証済みになっていないことを確認
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
