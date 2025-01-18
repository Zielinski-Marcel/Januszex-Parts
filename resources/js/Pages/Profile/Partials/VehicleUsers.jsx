import DangerButton from '@/Components/DangerButton';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import {Link, useForm} from '@inertiajs/react';
import React, { useRef, useState } from 'react';
import MessageBox from "@/Components/MessageBox.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function VehicleUsers({ users = [], vehicleId }) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const [userId, setUserId] = useState();

    const {
        delete: destroy,
        processing,
    } = useForm({});

    const confirmUserDeletion = (id) => () => {
        setConfirmingUserDeletion(true);
        setUserId(id)
    };

    const deleteUser = () => {
        destroy(`/leave/vehicle/${vehicleId}/${userId}`, {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);
    };

    return (
        <div>
            <div className="flex flex-col gap-4">
                <h2 className="text-lg font-medium text-gray-900">List of users sharing the car</h2>
                {users.map(user => (
                    <div key={user.id} className="flex gap-2">
                        <div className="content-center">
                            {user.name}
                        </div>
                        <div className="flex flex-1"/>
                    <DangerButton onClick={confirmUserDeletion(user.id)}>
                        Remove
                    </DangerButton>
                    </div>
                ))}
                <Link>
                    <Link href={`/create/vehicle`} className="w-full flex items-center pr-3 text-gray-500 rounded-lg">
                        <div className="w-6 h-6 mr-2 flex items-center justify-center bg-[#2ECC71] text-white rounded-full text-sm">
                            +
                        </div>
                        Invite user
                    </Link>
                </Link>
            </div>
            <MessageBox show={confirmingUserDeletion} onAccept={deleteUser} onClose={closeModal} isProcessing={processing} acceptButtonText="Delete User" title={`Are you sure you want to remove your user ${users.find(user => user.id === userId)?.name}?`}>
                Once you remove this user, you will lose access to all of its resources and
                data.
            </MessageBox>
        </div>
    );
}
