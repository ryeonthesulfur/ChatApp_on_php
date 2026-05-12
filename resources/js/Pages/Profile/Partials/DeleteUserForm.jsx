import { useForm } from '@inertiajs/react';
import { useRef, useState } from 'react';

export default function DeleteUserForm() {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef();

    const { data, setData, delete: destroy, processing, reset, errors, clearErrors } = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);
        clearErrors();
        reset();
    };

    return (
        <section>
            <h3>Delete Account</h3>
            <p>アカウントを削除すると、すべてのデータが完全に削除されます。</p>

            <div className="actions">
                <button
                    onClick={confirmUserDeletion}
                    className="btn"
                    style={{ backgroundColor: '#d65f4c', color: '#fff', cursor: 'pointer' }}
                >
                    Delete Account
                </button>
            </div>

            {confirmingUserDeletion && (
                <div style={{
                    position: 'fixed', top: 0, left: 0, right: 0, bottom: 0,
                    backgroundColor: 'rgba(0,0,0,0.5)', display: 'flex',
                    alignItems: 'center', justifyContent: 'center', zIndex: 1000
                }}>
                    <div style={{ backgroundColor: '#fff', padding: '40px', borderRadius: '5px', width: '500px' }}>
                        <h3>本当にアカウントを削除しますか？</h3>
                        <p>削除を確認するためにパスワードを入力してください。</p>

                        {errors.password && (
                            <div id="error_explanation">
                                <ul><li>{errors.password}</li></ul>
                            </div>
                        )}

                        <form onSubmit={deleteUser}>
                            <div className="field">
                                <div className="field-input">
                                    <input
                                        id="password"
                                        type="password"
                                        ref={passwordInput}
                                        value={data.password}
                                        placeholder="Password"
                                        autoFocus
                                        onChange={(e) => setData('password', e.target.value)}
                                    />
                                </div>
                            </div>
                            <div style={{ display: 'flex', gap: '10px', marginTop: '20px' }}>
                                <button
                                    type="button"
                                    onClick={closeModal}
                                    className="btn"
                                    style={{ backgroundColor: '#ccc', color: '#fff', cursor: 'pointer' }}
                                >
                                    Cancel
                                </button>
                                <input
                                    type="submit"
                                    value="Delete Account"
                                    className="btn"
                                    style={{ backgroundColor: '#d65f4c', color: '#fff' }}
                                    disabled={processing}
                                />
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </section>
    );
}
