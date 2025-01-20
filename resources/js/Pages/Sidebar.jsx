import React, { useState } from 'react';
import { Link } from "@inertiajs/react";

const Sidebar = ({ cars, selectedCarId}) => {
    const [showingSidebar, setShowingSidebar] = useState(false);
console.log(selectedCarId)
    return (

        <div className={showingSidebar ? "border-r border-gray-200 self-stretch" : "sm:border-r sm:border-gray-200 self-stretch"}>
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
                <div className="mb-6 flex justify-center items-center h-full flex-col">
                    <h1 className="text-2xl font-bold text-[#2ECC71]">List of your vehicles:</h1>
                </div>
                <div className="space-y-2">
                    <Link href={`/dashboard`}>
                        <button
                            className={`w-full flex items-center px-5  py-3 rounded-lg text-left bg-gray-50 border-2 border-primary ${
                                selectedCarId === undefined ? 'bg-gray-100 border-3 border-secondary' : ''
                            }`}
                        >
                            All Payments
                        </button>
                    </Link>
                    {cars.map((car) => (
                        <div className="space-y-2">
                        <Link key={car.id} href={`/dashboard/${car.id}`}>
                            <button
                                className={`w-full flex items-center px-5  py-3 rounded-lg text-left bg-gray-50 border-2 border-primary ${
                                    selectedCarId === car.id ? 'bg-gray-100 border-3 border-secondary' : ''
                                }`}
                            >
                                {car.brand} {car.model}
                            </button>
                        </Link>
                        </div>
                    ))}
                    <Link href={`/create/vehicle`} className="w-full flex items-center pt-2 pl-1 text-gray-500 rounded-lg">
                        <div className="w-6 h-6 mr-2 flex items-center justify-center bg-[#2ECC71] text-white rounded-full text-sm">
                            +
                        </div>
                        Add new vehicle
                    </Link>
                </div>
                <div className="mt-autoflex flex-col h-full"></div>
            </div>
        </div>

    );
}

export default Sidebar;
