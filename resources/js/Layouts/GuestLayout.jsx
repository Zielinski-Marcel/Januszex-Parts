import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center bg-white pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link
                    href="/"
                    className="text-primary text-6xl font-bold"
                >
                    HKS
                </Link>
            </div>

            <div className="mt-6 w-full overflow-hidden bg-primary px-1 py-1 shadow-md sm:max-w-md sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}

