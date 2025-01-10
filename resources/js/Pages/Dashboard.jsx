import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {useEffect, useState} from 'react';
import Sidebar from './Sidebar';

export default function Dashboard({vehicles, userid}){


    const expenses = [
        {
            id: 1,
            type: 'Paliwo',
            amount: '100,24 PLN',
            date: '20.12.2024',
            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
            image: '/placeholder.svg?height=40&width=40'
        },
        {
            id: 2,
            type: 'Mechanik',
            amount: '1000,00 PLN',
            date: '20.12.2024',
            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            image: '/placeholder.svg?height=40&width=40'
        },
        {
            id: 3,
            type: 'Inne',
            amount: '10,99 PLN',
            date: '20.12.2024',
            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            image: '/placeholder.svg?height=40&width=40'
        },
        {
            id: 4,
            type: 'Inne',
            amount: '50,00 PLN',
            date: '20.12.2024',
            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.',
            image: '/placeholder.svg?height=40&width=40'
        }
    ];

    const [selectedCar, setSelectedCar] = useState(vehicles[0]);

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
                                <Sidebar cars={vehicles} selectedCar={selectedCar} setSelectedCar={setSelectedCar} userid={userid} />
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
                                        {expenses.map((expense) => (
                                            <div key={expense.id} className="bg-white rounded-lg border border-gray-100">
                                                <div className="p-4">
                                                    <div className="flex items-start justify-between mb-2">
                                                        <div className="flex-1">
                                                            <div className="flex items-center gap-4 mb-1">
                                                                <span className="font-medium">{expense.type}</span>
                                                                <span className="text-gray-500">{expense.amount}</span>
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
                                                        <span className="text-gray-500 text-sm">{expense.date}</span>
                                                        <img
                                                            src={expense.image}
                                                            alt=""
                                                            className="w-10 h-10 rounded object-cover"
                                                        />
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
