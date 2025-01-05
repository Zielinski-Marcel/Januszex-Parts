// Sidebar.js
import React from 'react';

const Sidebar = ({ cars, selectedCar, setSelectedCar }) => {

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
                        {car.name}
                    </button>
                ))}
                <button className="w-full flex items-center p-3 text-gray-500 rounded-lg">
                    <div className="w-6 h-6 mr-2 flex items-center justify-center bg-[#2ECC71] text-white rounded-full text-sm">
                        +
                    </div>
                    Dodaj nowy pojazd
                </button>
            </div>
            <div className="mt-auto">
                <div className="flex items-center mb-4">
                    <img
                        src="/placeholder.svg?height=32&width=32"
                        alt=""
                        className="w-8 h-8 rounded-full"
                    />
                    <div className="ml-auto flex gap-2">
                        <button className="p-2">
                            <img
                                src="/placeholder.svg?height=20&width=20"
                                alt=""
                                className="w-5 h-5"
                            />
                        </button>
                        <button className="p-2">
                            <img
                                src="/placeholder.svg?height=20&width=20"
                                alt=""
                                className="w-5 h-5"
                            />
                        </button>
                    </div>
                </div>
                <div className="flex gap-2">
                    <button className="flex-1 p-2 text-center text-gray-700 hover:bg-gray-100 rounded">
                        Profil
                    </button>
                    <button className="flex-1 p-2 text-center text-gray-700 hover:bg-gray-100 rounded">
                        Wyloguj się
                    </button>
                </div>
            </div>
        </div>
    );
}

export default Sidebar;
