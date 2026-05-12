import { Link, useForm, usePage } from '@inertiajs/react';

export default function UpdateProfileInformation({ mustVerifyEmail, status }) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        name: user.name,
        email: user.email,
    });

    const submit = (e) => {
        e.preventDefault();
        patch(route('profile.update'));
    };

    return (
        <section>
            <h3>Profile Information</h3>
            <p>名前とメールアドレスの変更</p>

            {Object.keys(errors).length > 0 && (
                <div id="error_explanation">
                    <h2>{Object.keys(errors).length}つのエラーが見つかりました</h2>
                    <ul>
                        {Object.values(errors).map((error, i) => (
                            <li key={i}>{error}</li>
                        ))}
                    </ul>
                </div>
            )}

            {recentlySuccessful && (
                <div id="error_explanation" style={{ borderColor: '#38aef0' }}>
                    <p style={{ color: '#38aef0' }}>保存しました。</p>
                </div>
            )}

            <form onSubmit={submit}>
                <div className="field">
                    <div className="field-label">
                        <label htmlFor="name">Name</label>
                    </div>
                    <div className="field-input">
                        <input
                            id="name"
                            type="text"
                            value={data.name}
                            autoFocus
                            autoComplete="name"
                            onChange={(e) => setData('name', e.target.value)}
                            required
                        />
                    </div>
                </div>

                <div className="field">
                    <div className="field-label">
                        <label htmlFor="email">Email</label>
                    </div>
                    <div className="field-input">
                        <input
                            id="email"
                            type="email"
                            value={data.email}
                            autoComplete="username"
                            onChange={(e) => setData('email', e.target.value)}
                            required
                        />
                    </div>
                </div>

                {mustVerifyEmail && user.email_verified_at === null && (
                    <div className="field">
                        <p>メールアドレスが未認証です。
                            <Link href={route('verification.send')} method="post" as="button">
                                再送する
                            </Link>
                        </p>
                        {status === 'verification-link-sent' && (
                            <p style={{ color: '#38aef0' }}>認証メールを送信しました。</p>
                        )}
                    </div>
                )}

                <div className="actions">
                    <input type="submit" value="Save" className="btn" disabled={processing} />
                </div>
            </form>
        </section>
    );
}
