import {Head, useForm} from "@inertiajs/react";
import InputError from "@/Components/InputError.jsx";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import Checkbox from "@/Components/Checkbox.jsx";

export default function ({user}) {
    const form = useForm({"name": user.name, "email": user.email, "role": user.is_admin ? "admin" : "user"})
    console.log(user);

    function submit(e) {
        e.preventDefault();
        form.patch(`/admin/users/${user.id}`)
    }

    return (<AuthenticatedLayout>
            <Head title="Edit User"/>
            <div className="py-16">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex bg-white justify-center">
                                <div className="flex w-full mx-1 mb-3 mt-1 justify-center">
                                    <form onSubmit={submit} className="space-y-6 max-w-lg w-full justify-center">
                                        <header className="text-lg font-semibold mb-4 text-center">Edit user details</header>
                                        <input
                                            type="text"
                                            name="name"
                                            placeholder="name"
                                            value={form.data.name}
                                            onChange={(e) => form.setData("name", e.target.value)}
                                            className="mt-1 w-full block rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"

                                        />
                                        <InputError message={form.errors.name} className="mt-1"/>
                                        <input
                                            type="email"
                                            name="email"
                                            placeholder="email"
                                            value={form.data.email}
                                            onChange={(e) => form.setData("email", e.target.value)}
                                            className="mt-1 w-full block rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"

                                        />
                                        <InputError message={form.errors.email} className="mt-1"/>
                                        <button
                                            type="submit"
                                            className="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                        >
                                            Update user data
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
