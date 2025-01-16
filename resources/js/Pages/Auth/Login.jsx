import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            <div className="w-full max-w-lg mx-auto p-8 bg-white rounded-lg">
                {status && (
                    <div className="mb-4 text-sm font-medium text-green-600">
                        {status}
                    </div>
                )}

                <form onSubmit={submit} className="space-y-6">
                    <div>
                        <TextInput
                            id="email"
                            type="email"
                            required="true"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full rounded-md border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Email"
                            autoComplete="username"
                            onChange={(e) => setData('email', e.target.value)}
                        />
                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div>
                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full rounded-md border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Password"
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                        />
                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                            className="rounded border-gray-300 text-emerald-500 focus:ring-emerald-500"
                        />
                        <span className="ms-2 text-sm text-gray-600">
                            Remember me
                        </span>
                    </div>

                    <div className="space-y-3">
                        <PrimaryButton
                            className="w-full justify-center bg-emerald-400 hover:bg-secondary focus:bg-primary "
                            disabled={processing}
                        >
                            Log in
                        </PrimaryButton>

                        <button
                            type="button"
                            className="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200"
                        >
                            Sign in with Facebook
                        </button>
                    </div>

                    <div className="text-center text-sm">
                        <span className="text-gray-600">Not your account yet?&nbsp;&nbsp;</span>
                        <Link
                            href={route('register')}
                            className="text-emerald-500 hover:text-emerald-600 font-medium"
                        >
                            Sign up here
                        </Link>
                    </div>

                    {canResetPassword && (
                        <div className="text-center">
                            <Link
                                href={route('password.request')}
                                className="text-sm text-emerald-500 hover:text-emerald-600"
                            >
                                Forgot your password?
                            </Link>
                        </div>
                    )}
                </form>
            </div>
        </GuestLayout>
    );
}

