import { Head, useForm } from '@inertiajs/react';
import '../../../css/user.css';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <div className="account-page" id="account-page">
            <Head title="Forgot Password" />
            <div className="account-page__inner clearfix">
                <div className="account-page__inner--left account-page__header">
                    <h2>Forgot Password</h2>
                    <h5>パスワードの再設定</h5>
                </div>
                <div className="account-page__inner--right user-form">
                    {status && (
                        <div id="error_explanation">
                            <p>{status}</p>
                        </div>
                    )}
                    {errors.email && (
                        <div id="error_explanation">
                            <h2>1つのエラーが見つかりました</h2>
                            <ul>
                                <li>{errors.email}</li>
                            </ul>
                        </div>
                    )}
                    <p>登録したメールアドレスにパスワード再設定のリンクを送信します。</p>
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
                        <div className="actions">
                            <input
                                type="submit"
                                value="送信する"
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
