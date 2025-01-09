import {useForm} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";

export default function addVehicle({userid}){
    const form = useForm();

    function submit(e){
        e.preventDefault();
        form.post(`/create/vehicle`);
    }

    return(
        <AuthenticatedLayout>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex h-screen bg-white justify-center">
                                <div className="flex w-full ml-1 mr-1 justify-center">
                                    <form onSubmit={submit} className="space-y-5 max-w-lg w-full mt-1 justify-center">
                                        <input
                                            type="text"
                                            name="brand"
                                            placeholder="Brand"
                                            value={form.data.brand}
                                            onChange={(e) => form.setData("brand", e.target.value)}
                                            className="mt-1 w-full block rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                        />
                                        <input
                                            type="text"
                                            name="model"
                                            placeholder="Model"
                                            value={form.data.model}
                                            onChange={(e) => form.setData("model", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <input
                                            type="number"
                                            name="year_of_manufacture"
                                            placeholder="Year of Manufacture"
                                            value={form.data.year_of_manufacture}
                                            onChange={(e) => form.setData("year_of_manufacture", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <input
                                            type="text"
                                            name="fuel_type"
                                            placeholder="Fuel Type"
                                            value={form.data.fuel_type}
                                            onChange={(e) => form.setData("fuel_type", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <input
                                            type="number"
                                            name="purchase_date"
                                            placeholder="Purchase Date"
                                            value={form.data.purchase_date}
                                            onChange={(e) => form.setData("purchase_date", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <input
                                            type="text"
                                            name="color"
                                            placeholder="Color"
                                            value={form.data.color}
                                            onChange={(e) => form.setData("color", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <button
                                            type="submit"
                                            className="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                        >
                                            Dodaj nowy pojazd
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
