import { Head } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import '../../../css/user.css';

export default function Edit({ mustVerifyEmail, status }) {
    return (
        <div className="account-page" id="account-page">
            <Head title="Profile" />
            <div className="account-page__inner clearfix" style={{ display: 'block', width: '800px' }}>
                <h2>Profile</h2>
                <UpdateProfileInformationForm mustVerifyEmail={mustVerifyEmail} status={status} />
                <hr style={{ margin: '80px 0 10px 0' }} />
                <UpdatePasswordForm />
                <hr style={{ margin: '80px 0 10px 0' }} />
                <DeleteUserForm />
            </div>
        </div>
    );
}
