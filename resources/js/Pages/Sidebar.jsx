import React, { useState } from 'react';
import { Link } from "@inertiajs/react";

const Sidebar = ({ cars, selectedCarId, userid }) => {
    const [showingSidebar, setShowingSidebar] = useState(false);

    return (
        <div className={showingSidebar ? "border-r border-gray-200 h-full" : "sm:border-r sm:border-gray-200 h-full"}>
            {/*LOGIKA ZNIKANIA*/}
            <div className="sm:hidden pt-5">
                <button
                    onClick={() => setShowingSidebar((prevState) => !prevState)}
                    className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:outline-none"
                >
                    <svg
                        className="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            className={!showingSidebar ? 'inline-flex' : 'hidden'}
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            className={showingSidebar ? 'inline-flex' : 'hidden'}
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <div
                className={`${
                    showingSidebar ? 'block' : 'hidden'
                } sm:flex sm:flex-col w-64 p-4`}
            >
                {/*Reszta kodu*/}
                <div className="mb-6 flex justify-center items-center h-full flex-col">
                    <h1 className="text-2xl font-bold text-[#2ECC71]">Lista twoich pojazdów:</h1>
                </div>
                <div className="space-y-2">
                    {cars.map((car) => (
                        <Link href={`/dashboard/${car.id}`}>
                        <button
                            key={car.id}
                            className={`w-full flex items-center p-3 rounded-lg text-left ${
                                selectedCarId === car.id ? 'bg-gray-100 shadow-sm' : ''
                            }`}
                        >
                            <img
                                src="/placeholder.svg?height=24&width=24"
                                alt=""
                                className="w-6 h-6 mr-2"
                            />
                            {car.brand}
                        </button>
                        </Link>
                    ))}
                    <Link href={`/create/vehicle`} className="w-full flex items-center p-3 text-gray-500 rounded-lg">
                        <div className="w-6 h-6 mr-2 flex items-center justify-center bg-[#2ECC71] text-white rounded-full text-sm">
                            +
                        </div>
                        Dodaj nowy pojazd
                    </Link>
                </div>
                <div className="mt-autoflex flex-col h-full"></div>
            </div>
        </div>

    );
}

export default Sidebar;
