import { Head, Link, useForm } from '@inertiajs/react';
import '../../../css/user.css';

export default function Login({ canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <div className="account-page" id="account-page">
            <Head title="Log in" />
            <div className="account-page__inner clearfix">
                <div className="account-page__inner--left account-page__header">
                    <h2>Log in</h2>
                    <h5>登録しているユーザーでログイン</h5>
                    <div style={{ marginTop: '20px' }}>
                        <Link href={route('register')} className="btn" style={{ display: 'block', marginBottom: '10px', width: 'fit-content' }}>
                            Sign up
                        </Link>
                        {canResetPassword && (
                            <Link href={route('password.request')} className="btn" style={{ display: 'block', width: 'fit-content' }}>
                                Forgot your password?
                            </Link>
                        )}
                    </div>
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
                                    autoFocus
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                />
                            </div>
                        </div>

                        <div className="field">
                            <div className="field-label">
                                <label htmlFor="password">Password</label>
                                <i>（英数字6文字以上）</i>
                            </div>
                            <div className="field-input">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    autoComplete="off"
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                />
                            </div>
                        </div>

                        <div className="actions">
                            <input
                                type="submit"
                                value="Log in"
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
