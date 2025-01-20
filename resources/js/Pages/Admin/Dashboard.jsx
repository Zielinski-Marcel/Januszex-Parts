import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import DeleteVehicleForm from "@/Pages/Profile/Partials/DeleteVehicleForm.jsx";
import VehicleUsers from "@/Pages/Profile/Partials/VehicleUsers.jsx";
import React, {useState} from "react";
import Show from "@/Components/Show.jsx";
import DangerButton from "@/Components/DangerButton.jsx";
import MessageBox from "@/Components/MessageBox.jsx";
import InviteMessageBox from "@/Components/InviteMessageBox.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function EditVehicle({users, admin}) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const [userId, setUserId] = useState();


    const destroyForm = useForm({});

    const confirmUserDeletion = (id) => () => {
        setConfirmingUserDeletion(true);
        setUserId(id)
    };

    const deleteUser = () => {
        destroyForm.delete(`/admin/users/${userId}`, {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);
    };
    return (
        <AuthenticatedLayout>
            <Head title="Admin Panel - Users"/>
            <div className="py-12">
                <div className="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-4">
                        <div>
                            <div className="flex flex-col gap-4">
                                <Link href={`/admin/logs`}>
                                    <PrimaryButton className="bg-primary hover:bg-secondary w-full text-center flex justify-center py-4">
                                        Check All Logs
                                    </PrimaryButton>
                                </Link>
                                <h2 className="text-lg font-medium text-gray-900">List of Users</h2>
                                {users.map(user => (
                                    <div className="space-y-4">
                                        <div key={user.id} className="bg-white rounded-lg border border-gray-100 min-w-full">
                                            <div className="p-4">
                                                <div className="flex items-start justify-between mb-2">
                                                    <div className="flex-1">
                                                        <div className="flex items-center gap-4 mb-1">
                                                            <span className="font-medium">
                                                                {user.name}
                                                            </span>
                                                            <span className="text-gray-500">
                                                                {user.email}
                                                            </span>
                                                        </div>
                                                        <p className="text-sm text-gray-500 leading-relaxed">
                                                            Vehicles: {user.vehicles_count}
                                                        </p>

                                                    </div>
                                                    <div className="flex gap-4">
                                                        <Link href={`/admin/logs/${user.id}`}>
                                                            <button className="text-primary">Logs</button>
                                                        </Link>
                                                        <Link href={`/admin/users/${user.id}/edit`}>
                                                            <button className="text-blue-500">Edit</button>
                                                        </Link>
                                                        <button className="text-red-500" onClick={confirmUserDeletion(user.id)}>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                                <div className="flex justify-between items-end">
                                                    <span className="text-gray-500 text-sm">
                                                        {new Date(user.created_at).toLocaleDateString()}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <MessageBox
                                show={confirmingUserDeletion}
                                onAccept={deleteUser}
                                onClose={closeModal}
                                isProcessing={destroyForm.processing} acceptButtonText="Delete User"
                                title={`Are you sure you want to remove your user ${users.find(user => user.id === userId)?.name}?`}
                            >
                                Once you remove this user, you will lose access to all of its resources and
                                data.
                            </MessageBox>
                        </div>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
