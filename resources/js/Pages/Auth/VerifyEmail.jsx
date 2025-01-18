import PrimaryButton from '@/Components/PrimaryButton';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import SecondaryButton from "@/Components/SecondaryButton.jsx";

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const submit = (e) => {
        e.preventDefault();

        post(route('verification.send'));
    };
    const handleLogout = () => {
        post(route('logout'));
    };

    return (
        <GuestLayout>
            <Head title="Email Verification" />
            <div className="p-3">
            <div className="mb-4 text-sm text-gray-600 bg-white rounded">
                Thanks for signing up! Before getting started, could you verify
                your email address by clicking on the link we just emailed to
                you? If you didn't receive the email, we will gladly send you
                another.
            </div>

            {status === 'verification-link-sent' && (
                <div className="mb-4 text-sm font-medium text-green-600 bg-white rounded">
                    A new verification link has been sent to the email address
                    you provided during registration.
                </div>
            )}

            <form onSubmit={submit} className="bg-white">
                <div className="mt-4 flex items-center justify-between">
                    <PrimaryButton disabled={processing} className="bg-primary hover:bg-secondary">
                        Resend Verification Email
                    </PrimaryButton>
                    <SecondaryButton
                        onClick={handleLogout}
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="rounded-md text-sm text-blue-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Log Out
                    </SecondaryButton>
                </div>
            </form>
            </div>
        </GuestLayout>
    );
}
