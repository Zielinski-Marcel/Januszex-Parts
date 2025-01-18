import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import DeleteVehicleForm from "@/Pages/Profile/Partials/DeleteVehicleForm.jsx";
import Show from "@/Components/Show.jsx";
import LeaveVehicleForm from "@/Pages/Profile/Partials/LeaveVehicleForm.jsx";
import VehicleUsers from "@/Pages/Profile/Partials/VehicleUsers.jsx";

export default function EditVehicle({ vehicle, user, userList }) {

    return (
        <AuthenticatedLayout>
            <Head title="Manage Vehicle"/>
            <div className="py-12">
                <div className="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-4">
                            <div className="bg-white rounded-lg border border-gray-100 p-4">
                                <VehicleUsers vehicleId={vehicle.id} users={userList}>
                                </VehicleUsers>
                            </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
