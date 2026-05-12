import { useForm } from '@inertiajs/react';
import { useRef } from 'react';

export default function UpdatePasswordForm() {
    const passwordInput = useRef();
    const currentPasswordInput = useRef();

    const { data, setData, errors, put, reset, processing, recentlySuccessful } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword = (e) => {
        e.preventDefault();

        put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                if (errors.password) {
                    reset('password', 'password_confirmation');
                    passwordInput.current.focus();
                }
                if (errors.current_password) {
                    reset('current_password');
                    currentPasswordInput.current.focus();
                }
            },
        });
    };

    return (
        <section>
            <h3>Update Password</h3>
            <p>パスワードの変更</p>

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

            <form onSubmit={updatePassword}>
                <div className="field">
                    <div className="field-label">
                        <label htmlFor="current_password">Current Password</label>
                    </div>
                    <div className="field-input">
                        <input
                            id="current_password"
                            type="password"
                            ref={currentPasswordInput}
                            value={data.current_password}
                            autoComplete="current-password"
                            onChange={(e) => setData('current_password', e.target.value)}
                        />
                    </div>
                </div>

                <div className="field">
                    <div className="field-label">
                        <label htmlFor="password">New Password</label>
                        <i>（英数字6文字以上）</i>
                    </div>
                    <div className="field-input">
                        <input
                            id="password"
                            type="password"
                            ref={passwordInput}
                            value={data.password}
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                        />
                    </div>
                </div>

                <div className="field">
                    <div className="field-label">
                        <label htmlFor="password_confirmation">Confirm Password</label>
                    </div>
                    <div className="field-input">
                        <input
                            id="password_confirmation"
                            type="password"
                            value={data.password_confirmation}
                            autoComplete="new-password"
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                        />
                    </div>
                </div>

                <div className="actions">
                    <input type="submit" value="Save" className="btn" disabled={processing} />
                </div>
            </form>
        </section>
    );
}
