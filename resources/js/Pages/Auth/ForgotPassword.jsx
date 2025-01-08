import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="w-full max-w-lg mx-auto p-8 bg-white rounded-lg shadow-sm">
                <div className="mb-6 text-sm text-gray-600 text-center">
                    Forgot your password? No problem. Just let us know your email
                    address and we will email you a password reset link that will
                    allow you to choose a new one.
                </div>

                {status && (
                    <div className="mb-4 text-sm font-medium text-green-600 text-center">
                        {status}
                    </div>
                )}

                <form onSubmit={submit} className="space-y-6">
                    <div>
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full rounded-md border-gray-200"
                            isFocused={true}
                            onChange={(e) => setData('email', e.target.value)}
                            placeholder="Email"
                        />

                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="space-y-3">
                        <PrimaryButton
                            className="w-full justify-center bg-emerald-400 hover:bg-emerald-500 focus:bg-emerald-500"
                            disabled={processing}
                        >
                            Email Password Reset Link
                        </PrimaryButton>
                    </div>

                    <div className="text-center text-sm">
                        <span className="text-gray-600">Remember your password? </span>
                        <Link
                            href={route('login')}
                            className="text-emerald-500 hover:text-emerald-600 font-medium"
                        >
                            Log in here
                        </Link>
                    </div>
                </form>
            </div>
        </GuestLayout>
    );
}

