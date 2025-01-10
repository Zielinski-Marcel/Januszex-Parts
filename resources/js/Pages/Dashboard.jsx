import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {useEffect, useState} from 'react';
import Sidebar from './Sidebar';

export default function Dashboard({vehicles, vehicle, userid, spendings}){

    return (
        <AuthenticatedLayout>
            <Head title="Car Expenses" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className=" bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex h-full bg-white">
                                {/* Sidebar */}
                                <div>
                                <Sidebar cars={vehicles} selectedCarId={vehicle?.id} userid={userid} />
                                </div>
                                {/* Main Content */}
                                <div className="p-4">
                                    <div className="mb-4">
                                        <button className="w-full bg-primary text-white p-4 rounded-lg flex items-center justify-center">
                                            <span className="mr-2">+</span>
                                            Dodaj nową płatność
                                        </button>
                                    </div>
                                    <div className="space-y-4">

                                        {spendings.map((expense) => (
                                            <div key={expense.id} className="bg-white rounded-lg border border-gray-100">
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
                                                        <div className="flex gap-4">
                                                            <button className="text-blue-500">Edytuj</button>
                                                            <button className="text-red-500">Usuń</button>
                                                        </div>
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
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
