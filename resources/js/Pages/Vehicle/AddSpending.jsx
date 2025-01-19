import {Head, useForm} from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import InputError from "@/Components/InputError.jsx";
import {getCurrentDate} from "@/Helpers/DateHelper.js";

export default function AddSpending({vehicle}){
    const form = useForm();
    function submit(e){
        e.preventDefault();
        form.post(`/create/spending/${vehicle.id}`);
    }

    return(
        <AuthenticatedLayout>
            <Head title="Add Spending" />
            <div className="py-16">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex bg-white justify-center">
                                <div className="flex w-full mx-1 mb-3 mt-1 justify-center">
                                    <form onSubmit={submit} className="space-y-6 max-w-lg w-full justify-center">
                                        <header className="text-lg font-semibold mb-4 text-center">Enter your payment details</header>
                                        <input
                                            type="number"
                                            name="price"
                                            placeholder="Price"
                                            min="0"
                                            value={form.data.price}
                                            onChange={(e) => form.setData("price", e.target.value)}
                                            className="mt-1 w-full block rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"

                                        />
                                        <InputError message={form.errors.price} className="mt-1" />
                                        <input
                                            type="text"
                                            name="type"
                                            placeholder="Type"
                                            value={form.data.type}
                                            onChange={(e) => form.setData("type", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.type} className="mt-1" />
                                        <input
                                            type="date"
                                            name="date"
                                            min="2000-01-01"
                                            max={getCurrentDate()}
                                            placeholder="Date"
                                            value={form.data.date}
                                            onChange={(e) => form.setData("date", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.date} className="mt-1" />
                                        <input
                                            type="text"
                                            name="place"
                                            placeholder="Place"
                                            value={form.data.place}
                                            onChange={(e) => form.setData("place", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.place} className="mt-1" />
                                        <input
                                            type="text"
                                            name="description"
                                            placeholder="Description"
                                            value={form.data.description}
                                            onChange={(e) => form.setData("description", e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-primary"
                                        />
                                        <InputError message={form.errors.description} className="mt-1" />
                                        <button
                                            type="submit"
                                            className="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                        >
                                            Add payment
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
