import DangerButton from '@/Components/DangerButton';
import {Link, useForm} from '@inertiajs/react';
import { useState } from 'react';
import MessageBox from "@/Components/MessageBox.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function DeleteVehicleForm({ vehicles = [] }) {
    const [confirmingVehicleDeletion, setConfirmingVehicleDeletion] = useState(false);
    const [vehicleId, setVehicleId] = useState();

    const {
        delete: destroy,
        processing,
    } = useForm({});

    const confirmVehicleDeletion = (id) => () => {
        setConfirmingVehicleDeletion(true);
        setVehicleId(id)
    };

    const deleteVehicle = () => {
        destroy(`/deleteuser/vehicle/${vehicleId}`, {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    };

    const closeModal = () => {
        setConfirmingVehicleDeletion(false);
    };

    return (
        <div>
            <div className="flex flex-col gap-4">
                <h2 className="text-lg font-medium text-gray-900">List of Your Vehicles</h2>
                {vehicles.map(vehicle => (
                    <div key={vehicle.id} className="flex gap-2">
                        <div className="content-center">
                            {vehicle.brand}, &nbsp;
                            {vehicle.model}
                        </div>
                        <div className="flex flex-1"/>
                        <Link href={`/edit/vehicle/${vehicle.id}`}>
                        <PrimaryButton className="bg-primary hover:bg-secondary">
                            Manage your vehicle
                        </PrimaryButton>
                        </Link>
                    <DangerButton onClick={confirmVehicleDeletion(vehicle.id)}>
                        Delete Vehicle
                    </DangerButton>
                    </div>
                ))}
            </div>
            <MessageBox show={confirmingVehicleDeletion} onAccept={deleteVehicle} onClose={closeModal} isProcessing={processing} acceptButtonText="Delete Vehicle" title={`Are you sure you want to delete your vehicle ${vehicles.find(vehicle => vehicle.id === vehicleId)?.brand}?`}>
                Once your vehicle is deleted, all of its resources and
                data will be permanently deleted.
            </MessageBox>
        </div>
    );
}
