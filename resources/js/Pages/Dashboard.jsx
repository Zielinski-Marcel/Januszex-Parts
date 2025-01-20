import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import React, {useMemo, useState} from 'react';
import Sidebar from './Sidebar';
import MessageBox from "@/Components/MessageBox.jsx";
import Show from "@/Components/Show.jsx";
import FilterPanel from "@/Components/FilterPanel.jsx";
import SortPanel from "@/Components/SortPanel.jsx";

export default function Dashboard({vehicles, vehicle, userid, spendings, coowners, spendingsTypes}){
    const [confirmingSpendingDeletion, setConfirmingSpendingDeletion] = useState(false);
    const [spendingId, setSpendingId] = useState();
    const [spendingSelectedCoowner, setSpendingSelectedCoowner] = useState(Object.fromEntries(Object.keys(coowners).map(key=>[key, true])));
    const [spendingSelectedType, setSpendingSelectedType] = useState(Object.fromEntries(Object.keys(spendingsTypes).map(key=>[key, true])));
    const [sortBy, setSortBy] = useState("oldDate");
    const [startDate, setStartDate] = useState(null);
    const [endDate, setEndDate] = useState(null);

    const deleteForm = useForm();

    function sort(a, b){
        switch (sortBy){
            case "newDate":
                return new Date(a.date).getTime() - new Date(b.date).getTime();
            case "oldDate":
                return new Date(b.date).getTime() - new Date(a.date).getTime();
            case "priceLow":
                return a.price - b.price;
            case "priceHigh":
                return b.price - a.price;
            case "type":
                return a.type.localeCompare(b.type);
        }
    }

    function filterByCoowner(spending){
        return spendingSelectedCoowner[spending.user.name];
    }

    function filterByTypes(spending){
        return spendingSelectedType[spending.type];
    }

    function filterByDate(spending) {
        const spendingDate = new Date(spending.date);
        if (startDate && spendingDate < new Date(startDate)) return false;
        if (endDate && spendingDate > new Date(endDate)) return false;
        return true;
    }

    const sortedSpendings = useMemo(()=>spendings.filter(filterByCoowner).filter(filterByTypes).filter(filterByDate).toSorted(sort),[spendingSelectedCoowner, spendings, coowners, spendingSelectedType, spendingsTypes, startDate, endDate, sort]);

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

    return (
        <AuthenticatedLayout>
            <Head title="Car Expenses" />
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8   min-h-[calc(100vh-65px)] flex flex-col justify-center">
                    <div className=" bg-white shadow-sm sm:rounded-lg box-border  my-12 h-full p-6 text-gray-900 flex-row flex flex-1">

                                <Sidebar cars={vehicles} selectedCarId={vehicle?.id} userid={userid} />

                                <div className="p-4 w-full">
                                    <Show when={vehicle!==null}>
                                        <div className="flex mb-4 gap-2">
                                            <Link href={`/create/spending/${vehicle?.id}`}>
                                                <button
                                                    className="w-full bg-primary text-white py-2 px-6 rounded-lg flex items-center justify-center">
                                                    <span className="mr-2">+</span>
                                                    Add new payment
                                                </button>
                                            </Link>
                                            <div className="flex flex-1"/>
                                            <SortPanel
                                                sortBy={sortBy}
                                                setSortBy={setSortBy}
                                            />
                                            <FilterPanel
                                                coowners={Object.keys(coowners)}
                                                spendingsTypes={Object.keys(spendingsTypes)}
                                                setSpendingSelectedCoowner={setSpendingSelectedCoowner}
                                                spendingSelectedCoowner={spendingSelectedCoowner}
                                                spendingSelectedType={spendingSelectedType}
                                                setSpendingSelectedType={setSpendingSelectedType}
                                                startDate={startDate}
                                                setStartDate={setStartDate}
                                                endDate={endDate}
                                                setEndDate={setEndDate}
                                            />
                                        </div>
                                    </Show>
                                    <div className="space-y-4">

                                        {sortedSpendings.map((expense) => (
                                            <div key={expense.id}
                                                 className="bg-white rounded-lg border border-gray-100 min-w-full">
                                            <div className="p-4">
                                                <div className="flex items-start justify-between mb-2">
                                                        <div className="flex-1">
                                                            <div className="flex items-center gap-4 mb-1">
                                                                <span className="font-medium">{expense.user.name}&nbsp;({expense.vehicle.brand}&nbsp;{expense.vehicle.model})</span>
                                                                <span className="text-gray-500">{expense.price} PLN</span>
                                                            </div>
                                                            <p className="text-sm leading-relaxed">
                                                                {expense.type}
                                                            </p>
                                                            <p className="text-sm text-gray-500 leading-relaxed">
                                                                {expense.description}
                                                            </p>

                                                        </div>
                                                        <Show when={expense.user_id === userid}>
                                                            <div className="flex gap-4">
                                                                <Link href={`/edit/spending/${expense.id}`}>
                                                                <button className="text-blue-500">Edit</button>
                                                                </Link>
                                                                <button className="text-red-500" onClick={confirmSpendingDeletion(expense.id)}>Delete</button>
                                                            </div>
                                                        </Show>
                                                    </div>
                                                    <div className="flex justify-between items-end">
                                                        <span className="text-gray-500 text-sm">{new Date(expense.date).toLocaleDateString()}</span>
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
