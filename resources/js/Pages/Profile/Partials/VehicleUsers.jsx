import DangerButton from '@/Components/DangerButton';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import {Link, useForm} from '@inertiajs/react';
import React, { useRef, useState } from 'react';
import MessageBox from "@/Components/MessageBox.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import InviteMessageBox from "@/Components/InviteMessageBox.jsx";
import Show from "@/Components/Show.jsx";

export default function VehicleUsers({ users = [], vehicleId, ownerId }) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const [showInviteInput, setShowInviteInput] = useState(false);
    const [userId, setUserId] = useState();

    const {
        delete: destroy,
        processing,
    } = useForm({});
    const inviteForm = useForm({email:"", vehicle_id:vehicleId});

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
    const inviteUser = () => {
        inviteForm.post(`/invite`, {
            preserveScroll: true,
            onSuccess: () => setShowInviteInput(false),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);
    };
    const closeInviteInput = () => {
        setShowInviteInput(false);
    };

    return (
        <div>
            <div className="flex flex-col gap-4">
                <h2 className="text-lg font-medium text-gray-900">List of Users Sharing The Car</h2>
                {users.map(user => (
                    <div key={user.id} className="flex gap-2">
                        <div className="content-center">
                            {user.name}
                        </div>
                        <div className="flex flex-1"/>
                        <Show when={ownerId!==user.id}>
                            <DangerButton onClick={confirmUserDeletion(user.id)}>
                                Remove
                            </DangerButton>
                        </Show>
                    </div>
                ))}
                    <p onClick={()=>setShowInviteInput(true)} className="w-full flex items-center pr-3 text-gray-500 rounded-lg cursor-pointer">
                        <div className="w-6 h-6 mr-2 flex items-center justify-center bg-[#2ECC71] text-white rounded-full text-sm">
                            +
                        </div>
                        Invite user
                    </p>
            </div>
            <MessageBox show={confirmingUserDeletion} onAccept={deleteUser} onClose={closeModal} isProcessing={processing} acceptButtonText="Delete User" title={`Are you sure you want to remove your user ${users.find(user => user.id === userId)?.name}?`}>
                Once you remove this user, you will lose access to all of its resources and
                data.
            </MessageBox>
            <InviteMessageBox
                show={showInviteInput}
                onAccept={inviteUser}
                onClose={closeInviteInput}
                isProcessing={inviteForm.processing}
                onChange={(e) => inviteForm.setData("email", e.target.value)}
                error={inviteForm.errors["email"]}
            />
        </div>
    );
}
