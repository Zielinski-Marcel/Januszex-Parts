import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import {useEffect, useState} from 'react';
import Sidebar from './Sidebar';
import MessageBox from "@/Components/MessageBox.jsx";
import Show from "@/Components/Show.jsx";

export default function Dashboard({vehicles, vehicle, userid, spendings}){
    const [confirmingSpendingDeletion, setConfirmingSpendingDeletion] = useState(false);
    const [spendingId, setSpendingId] = useState();

    const deleteForm = useForm();

    const confirmSpendingDeletion = (id) => () => {
        setConfirmingSpendingDeletion(true);
        setSpendingId(id)
    };

    const deleteSpending = () => {
        deleteForm.delete(`/deleteuser/spending/${spendingId}`, {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    };

    const closeModal = () => {
        setConfirmingSpendingDeletion(false);
    };

    console.log(vehicle);

    return (
        <AuthenticatedLayout>
            <Head title="Car Expenses" />
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8   min-h-[calc(100vh-65px)] flex flex-col justify-center">
                    <div className=" bg-white shadow-sm sm:rounded-lg box-border  my-12 h-full p-6 text-gray-900 flex-row flex flex-1">
                                {/* Sidebar */}

                                <Sidebar cars={vehicles} selectedCarId={vehicle?.id} userid={userid} />

                                {/* Main Content */}
                                <div className="p-4 w-full">
                                    <Show when={vehicle!==null}>
                                        <div className="mb-4">
                                            <Link href={`/create/spending/${vehicle?.id}`}>
                                            <button className="w-full bg-primary text-white p-4 rounded-lg flex items-center justify-center">
                                                <span className="mr-2">+</span>
                                                Dodaj nową płatność
                                            </button>
                                            </Link>
                                        </div>
                                    </Show>
                                    <div className="space-y-4">

                                        {spendings.map((expense) => (
                                            <div key={expense.id} className="bg-white rounded-lg border border-gray-100 min-w-full">
                                                <div className="p-4">
                                                    <div className="flex items-start justify-between mb-2">
                                                        <div className="flex-1">
                                                            <div className="flex items-center gap-4 mb-1">
                                                                <span className="font-medium">{expense.type}</span>
                                                                <span className="text-gray-500">{expense.price}</span>
                                                            </div>
                                                            <p className="text-sm text-gray-500 leading-relaxed">
                                                                {expense.description}
                                                            </p>
                                                        </div>
                                                        <Show when={expense.user_id===userid}>
                                                            <div className="flex gap-4">
                                                                <Link href={`/edit/spending/${expense.id}`}>
                                                                 <button className="text-blue-500">Edytuj</button>
                                                                </Link>
                                                                <button className="text-red-500" onClick={confirmSpendingDeletion(expense.id)}>Usuń</button>
                                                            </div>
                                                        </Show>
                                                    </div>
                                                    <div className="flex justify-between items-end">
                                                        <span className="text-gray-500 text-sm">{new Date(expense.date).toLocaleDateString()}</span>
                                                        {/*<img*/}
                                                        {/*    src={spendings.image}*/}
                                                        {/*    alt=""*/}
                                                        {/*    className="w-10 h-10 rounded object-cover"*/}
                                                        {/*/>*/}
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                    </div>


            <MessageBox show={confirmingSpendingDeletion} onAccept={deleteSpending} onClose={closeModal} isProcessing={deleteForm.processing} acceptButtonText="Delete Spending" title={`Are you sure you want to delete your spending?`}>
                Once your spending is deleted, all of its resources and
                data will be permanently deleted.
            </MessageBox>
        </AuthenticatedLayout>
    );
}
