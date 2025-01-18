import {useForm} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import InputError from "@/Components/InputError.jsx";

export default function AddVehicle({userid}){
    const form = useForm();
    function submit(e){
        e.preventDefault();
        form.post(`/create/vehicle`);
    }

    return(
        <AuthenticatedLayout>
            <div className="py-16">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex bg-white justify-center">
                                <div className="flex w-full mx-1 mb-3 mt-1 justify-center">
                                    <form onSubmit={submit} className="space-y-6 max-w-lg w-full justify-center">
                                        <header className="text-lg font-semibold mb-4 text-center">Enter vehicle details</header>
                                        <input
                                            type="text"
                                            name="brand"
                                            placeholder="Brand"
                                            value={form.data.brand}
                                            onChange={(e) => form.setData("brand", e.target.value)}
                                            className="mt-1 w-full block rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                        />
                                        <InputError message={form.errors.brand} className="mt-1" />
                                        <input
                                            type="text"
                                            name="model"
                                            placeholder="Model"
                                            value={form.data.model}
                                            onChange={(e) => form.setData("model", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.model} className="mt-1" />
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
                                        <InputError message={form.errors.year_of_manufacture} className="mt-1" />
                                        <input
                                            type="text"
                                            name="fuel_type"
                                            placeholder="Fuel Type"
                                            value={form.data.fuel_type}
                                            onChange={(e) => form.setData("fuel_type", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.fuel_type} className="mt-1" />
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
                                        <InputError message={form.errors.purchase_date} className="mt-1" />
                                        <input
                                            type="text"
                                            name="color"
                                            placeholder="Color"
                                            value={form.data.color}
                                            onChange={(e) => form.setData("color", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.color} className="mt-1" />
                                        <button
                                            type="submit"
                                            className="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                        >
                                            Add vehicle
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    )

}
