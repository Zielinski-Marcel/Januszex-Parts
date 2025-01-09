import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import { useRef, useState } from 'react';

export default function DeleteVehicleForm({ className = '', vehicles = [] }) {
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

    const deleteVehicle = (e) => {
        e.preventDefault();

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
                Lista pojazdów
                {vehicles.map(vehicle=> (
                    <div className="flex">
                        {vehicle.brand}, &nbsp;
                        {vehicle.model}
                        <div className="flex flex-1">
                        </div>
                    <DangerButton onClick={confirmVehicleDeletion(vehicle.id)}>
                        Delete Vehicle
                    </DangerButton>
                    </div>
                ))}
            </div>
            <Modal show={confirmingVehicleDeletion} onClose={closeModal}>
                <form onSubmit={deleteVehicle} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Are you sure you want to delete your vehicle {vehicles.find(vehicle => vehicle.id === vehicleId)?.brand}?
                    </h2>

                    <p className="mt-1 text-sm text-gray-600">
                        Once your vehicle is deleted, all of its resources and
                        data will be permanently deleted. Please enter your
                        password to confirm you would like to permanently delete
                        your account.
                    </p>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>
                            Cancel
                        </SecondaryButton>

                        <DangerButton className="ms-3" disabled={processing}>
                            Delete Vehicle
                        </DangerButton>
                    </div>
                </form>
            </Modal>

        </div>
    );
}
