import DangerButton from '@/Components/DangerButton';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import { useForm } from '@inertiajs/react';
import { useRef, useState } from 'react';
import MessageBox from "@/Components/MessageBox.jsx";

export default function LeaveVehicleForm({ vehicles = [] }) {
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
        destroy(`/leave/vehicle/${vehicleId}`, {
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
                <h2 className="text-lg font-medium text-gray-900">Lista Współdzielonych Pojazdów</h2>
                {vehicles.map(vehicle => (
                    <div key={vehicle.id} className="flex">
                        <div className="content-center">
                            {vehicle.brand}, &nbsp;
                            {vehicle.model}
                        </div>
                        <div className="flex flex-1"/>

                    <DangerButton onClick={confirmVehicleDeletion(vehicle.id)}>
                        Leave Vehicle
                    </DangerButton>
                    </div>
                ))}
            </div>
            <MessageBox show={confirmingVehicleDeletion} onAccept={deleteVehicle} onClose={closeModal} isProcessing={processing} acceptButtonText="Leave Vehicle" title={`Are you sure you want to leave this vehicle ${vehicles.find(vehicle => vehicle.id === vehicleId)?.brand}?`}>
                Once you leave this vehicle, you will lose access to all of its resources and
                data.
            </MessageBox>
        </div>
    );
}
