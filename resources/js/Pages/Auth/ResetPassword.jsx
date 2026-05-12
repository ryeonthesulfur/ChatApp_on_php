import { Head, useForm } from '@inertiajs/react';
import '../../../css/user.css';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="account-page" id="account-page">
            <Head title="Reset Password" />
            <div className="account-page__inner clearfix">
                <div className="account-page__inner--left account-page__header">
                    <h2>Reset Password</h2>
                    <h5>パスワードの再設定</h5>
                </div>
                <div className="account-page__inner--right user-form">
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
                    <form onSubmit={submit}>
                        <div className="field">
                            <div className="field-label">
                                <label htmlFor="email">Email</label>
                            </div>
                            <div className="field-input">
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    autoComplete="username"
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                />
                            </div>
                        </div>

                        <div className="field">
                            <div className="field-label">
                                <label htmlFor="password">新しいPassword</label>
                                <i>（英数字6文字以上）</i>
                            </div>
                            <div className="field-input">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    autoFocus
                                    autoComplete="new-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                />
                            </div>
                        </div>

                        <div className="field">
                            <div className="field-label">
                                <label htmlFor="password_confirmation">Password Confirmation</label>
                            </div>
                            <div className="field-input">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    autoComplete="new-password"
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    required
                                />
                            </div>
                        </div>

                        <div className="actions">
                            <input
                                type="submit"
                                value="Reset Password"
                                className="btn"
                                disabled={processing}
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
