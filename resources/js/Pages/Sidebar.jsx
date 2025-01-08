// Sidebar.js
import React from 'react';
import {Link} from "@inertiajs/react";

const Sidebar = ({ cars, selectedCar, setSelectedCar, userid }) => {

    return (
        <div className="w-64 p-4 flex flex-col border-r border-gray-200">
            <div className="mb-6 flex justify-center items-center h-24">
                <h1 className="text-2xl font-bold text-[#2ECC71]">Lista twoich pojazdów:</h1>
            </div>
            <div className="space-y-2">
                {cars.map((car) => (
                    <button
                        key={car.id}
                        onClick={() => setSelectedCar(car)}
                        className={`w-full flex items-center p-3 rounded-lg text-left ${
                            selectedCar.id === car.id ? 'bg-gray-100 shadow-sm' : ''
                        }`}
                    >
                        <img
                            src="/placeholder.svg?height=24&width=24"
                            alt=""
                            className="w-6 h-6 mr-2"
                        />
                        {car.brand}
                    </button>
                ))}
                <Link href={`/user/${userid}/vehicle/create`} className="w-full flex items-center p-3 text-gray-500 rounded-lg">
                    <div className="w-6 h-6 mr-2 flex items-center justify-center bg-[#2ECC71] text-white rounded-full text-sm">
                        +
                    </div>
                    Dodaj nowy pojazd
                </Link>
            </div>
            <div className="mt-auto">


            </div>
        </div>
    );
}

export default Sidebar;
