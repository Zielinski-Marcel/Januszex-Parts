import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import DeleteVehicleForm from "@/Pages/Profile/Partials/DeleteVehicleForm.jsx";

export default function Edit({ mustVerifyEmail, vehicles, status }) {
    return (
        <AuthenticatedLayout>
            <Head title="Profile" />

            <div className="py-12">
                <div className="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-4">
                            <div className="bg-white rounded-lg border border-gray-100 p-4">
                                <UpdateProfileInformationForm
                                    mustVerifyEmail={mustVerifyEmail}
                                    status={status}
                                />
                            </div>

                        <div className="bg-white rounded-lg border border-gray-100 p-4">
                                <UpdatePasswordForm/>
                        </div>

                        <div className="bg-white rounded-lg border border-gray-100 p-4">
                                <DeleteVehicleForm vehicles={vehicles}/>
                            </div>

                            <div className="bg-white rounded-lg border border-gray-100 p-4">
                                <DeleteUserForm/>
                            </div>
                        </div>
                    </div>
                </div>
        </AuthenticatedLayout>
);
}
