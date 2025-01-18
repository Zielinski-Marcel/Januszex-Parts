import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, usePage} from '@inertiajs/react';
import DangerButton from "@/Components/DangerButton.jsx";
import React from "react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import Show from "@/Components/Show.jsx";

export default function Invites({sentInvites}) {
    const invites = usePage().props.auth.invites;
    const user = usePage().props.auth.user;
console.log(invites);

    return (

        <AuthenticatedLayout>
            <Head title="Manage Vehicle"/>
            <div className="py-12">
                <div className="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-4">
                        <div className="flex flex-col gap-4">

                            <h2 className="text-lg font-medium text-gray-900">List of invites</h2>
                            <Show when={invites.length===0}>
                                <p className="text-gray-200 w-full flex justify-center text-2xl py-5"> List is empty</p>
                            </Show>
                            {invites.map(invite => (
                                <div className="bg-white rounded-lg border border-gray-100 p-4">

                                    <div key={invite.id} className="flex-col flex gap-4">

                                        <div className="content-center">
                                            <b>{invite.invitor.name}</b> invited you to share a car!
                                        </div>
                                        <div className="content-center">
                                            Brand:&nbsp;{invite.vehicle.brand}
                                        </div>
                                        <div className="content-center">
                                            Model:&nbsp;{invite.vehicle.model}
                                        </div>
                                        <div className="content-center">
                                            Fuel:&nbsp;{invite.vehicle.fuel_type}
                                        </div>
                                        <div className="content-center">
                                            Year:&nbsp;{invite.vehicle.year_of_manufacture}
                                        </div>
                                        <div className="flex gap-2">
                                            <Link method="POST" href={`/invite/${invite.verification_token}`}>
                                                <PrimaryButton>Accept</PrimaryButton>
                                            </Link>
                                            <Link method="DELETE" href={`/invite/${invite.id}`}>
                                                <DangerButton>
                                                    Reject
                                                </DangerButton>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}

                        </div>
                        <div className="flex flex-col gap-4">
                            <h2 className="text-lg font-medium text-gray-900">Sent Invites</h2>
                            <Show when={sentInvites.length===0}>
                                <p className="text-gray-200 w-full flex justify-center text-2xl py-5"> List is empty</p>
                            </Show>
                            {sentInvites.map(invite => (
                                <div className="bg-white rounded-lg border border-gray-100 p-4">

                                    <div key={invite.id} className="flex-col flex gap-4">

                                        <div className="content-center">
                                           You invited <b>{invite.email}</b>
                                        </div>
                                        <div className="content-center">
                                            Brand:&nbsp;{invite.vehicle.brand}
                                        </div>
                                        <div className="content-center">
                                            Model:&nbsp;{invite.vehicle.model}
                                        </div>
                                        <div className="content-center">
                                            Fuel:&nbsp;{invite.vehicle.fuel_type}
                                        </div>
                                        <div className="content-center">
                                            Year:&nbsp;{invite.vehicle.year_of_manufacture}
                                        </div>
                                        <div className="flex gap-2">
                                            <Link method="DELETE" href={`/invite/${invite.id}`}>
                                                <DangerButton>
                                                    Cancel
                                                </DangerButton>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
