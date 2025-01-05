import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center bg-white pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link
                    href="/"
                    className="text-4xl font-serif text-emerald-600 tracking-wider"
                    style={{
                        textShadow: '1px 1px 0 black, -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black',
                        letterSpacing: '0.1em'
                    }}
                >
                    HKS
                </Link>
            </div>

            <div className="mt-6 w-full overflow-hidden bg-emerald-500 px-1 py-1 shadow-md sm:max-w-md sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}

