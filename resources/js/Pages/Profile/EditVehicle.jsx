import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/react';
import DeleteVehicleForm from "@/Pages/Profile/Partials/DeleteVehicleForm.jsx";
import VehicleUsers from "@/Pages/Profile/Partials/VehicleUsers.jsx";
import InputError from "@/Components/InputError.jsx";

export default function EditVehicle({ vehicle, user, userList }) {
    const form = useForm({
        "brand": vehicle.brand,
        "model": vehicle.model,
        "year_of_manufacture": vehicle.year_of_manufacture,
        "fuel_type": vehicle.fuel_type,
        "purchase_date": vehicle.purchase_date,
        "color": vehicle.color
    });

    function submit(e){
        e.preventDefault();
        form.patch(`/edit/vehicle/${vehicle.id}`);
    }

    return (
        <AuthenticatedLayout>
            <Head title="Manage Vehicle"/>
            <div className="py-12">
                <div className="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-4">
                        <div className="bg-white rounded-lg border border-gray-100 p-4">
                            <form onSubmit={submit} className="flex flex-col gap-2">
                                <header className="text-lg font-medium text-gray-900">Edit Your Vehicle Details</header>
                                <input
                                    type="text"
                                    name="brand"
                                    placeholder="Brand"
                                    value={form.data.brand}
                                    onChange={(e) => form.setData("brand", e.target.value)}
                                    className="mt-1 w-full block rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                />
                                <InputError message={form.errors.brand} className="mt-1"/>
                                <input
                                    type="text"
                                    name="model"
                                    placeholder="Model"
                                    value={form.data.model}
                                    onChange={(e) => form.setData("model", e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                />
                                <InputError message={form.errors.model} className="mt-1"/>
                                <input
                                    type="number"
                                    min="1886"
                                    max={new Date().getFullYear()}
                                    name="year_of_manufacture"
                                    placeholder="Year of Manufacture"
                                    value={form.data.year_of_manufacture}
                                    onChange={(e) => form.setData("year_of_manufacture", e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                />
                                <InputError message={form.errors.year_of_manufacture} className="mt-1"/>
                                <input
                                    type="text"
                                    name="fuel_type"
                                    placeholder="Fuel Type"
                                    value={form.data.fuel_type}
                                    onChange={(e) => form.setData("fuel_type", e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                />
                                <InputError message={form.errors.fuel_type} className="mt-1"/>
                                <input
                                    type="number"
                                    min="0"
                                    max={new Date().getFullYear()}
                                    name="purchase_date"
                                    placeholder="Purchase Date"
                                    value={form.data.purchase_date}
                                    onChange={(e) => form.setData("purchase_date", e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                />
                                <InputError message={form.errors.purchase_date} className="mt-1"/>
                                <input
                                    type="text"
                                    name="color"
                                    placeholder="Color"
                                    value={form.data.color}
                                    onChange={(e) => form.setData("color", e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                />
                                <InputError message={form.errors.color} className="mt-1"/>
                                <button
                                    type="submit"
                                    className="mt-1 w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                >
                                    Edit vehicle
                                </button>
                            </form>
                        </div>
                        <div className="bg-white rounded-lg border border-gray-100 p-4">
                            <VehicleUsers vehicleId={vehicle.id} users={userList} ownerId={vehicle.owner_id}>
                            </VehicleUsers>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
