import {Link} from "@inertiajs/react";

export default function ErrorPage({ status }) {
    const title = {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden',
    }[status]

    const description = {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.',
    }[status]

    return (
        <div className="flex justify-center items-center min-h-screen bg-gray-100">
            <div className="flex flex-col w-full mx-1 mb-3 mt-1 bg-white items-center p-8 text-gray-900 shadow-sm sm:rounded-lg max-w-2xl h-fit">
                    <h1 className="text-primary font-bold text-2xl mb-4">{title}</h1>
                    <div>{description}</div>
                <Link href={`/dashboard`}>
                    <button className="w-full bg-primary text-white p-2 mt-4 rounded-lg flex items-center justify-center">
                        Back to Dashboard
                    </button>
                </Link>
            </div>
        </div>
            )
            }
