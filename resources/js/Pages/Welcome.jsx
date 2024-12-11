import React, { useState } from 'react';

const Cars = () => {
    // Lista aut
    const cars = [
        { id: 1, name: 'Toyota Corolla', year: 2015, cost: '50,000 PLN' },
        { id: 2, name: 'Ford Focus', year: 2018, cost: '60,000 PLN' },
        { id: 3, name: 'BMW 320i', year: 2020, cost: '120,000 PLN' },
    ];

    // Historia kosztów dla każdego auta
    const initialCostHistory = {
        1: [
            { id: 1, type: 'Tankowanie', amount: '200 PLN', date: '2024-12-01' },
            { id: 2, type: 'Serwis', amount: '500 PLN', date: '2024-11-15' },
        ],
        2: [
            { id: 1, type: 'Tankowanie', amount: '180 PLN', date: '2024-12-03' },
        ],
        3: [],
    };

    // Stan wybranego auta
    const [selectedCar, setSelectedCar] = useState(null);

    // Historia kosztów (zainicjowana na podstawie powyższych danych)
    const [costHistory, setCostHistory] = useState(initialCostHistory);

    // Dodawanie nowego kosztu
    const addCost = (carId, newCost) => {
        setCostHistory((prevHistory) => ({
            ...prevHistory,
            [carId]: [...prevHistory[carId], newCost],
        }));
    };

    return (
        <div style={{ display: 'flex', height: '100vh', flexDirection: 'column' }}>
            {/* Górny panel */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', background: '#f4f4f4', padding: '10px 20px', borderBottom: '1px solid blue' }}>
                <h3>Historia kosztów auta</h3>
                <div style={{ fontWeight: 'bold' }}>Powiadomienia</div>
            </div>

            <div style={{ display: 'flex', flexGrow: 1 }}>
                {/* Lewy panel */}
                <div style={{ width: '250px', background: '#f4f4f4', padding: '20px', borderRight: '1px solid blue', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                    <div>
                        <h3>Lista Aut</h3>
                        <ul style={{ listStyle: 'none', padding: 0 }}>
                            {cars.map((car) => (
                                <li
                                    key={car.id}
                                    style={{
                                        padding: '10px',
                                        cursor: 'pointer',
                                        borderBottom: '1px solid #eee',
                                        background: selectedCar?.id === car.id ? '#ddd' : 'transparent',
                                    }}
                                    onClick={() => setSelectedCar(car)}
                                >
                                    {car.name}
                                </li>
                            ))}
                        </ul>
                    </div>
                    <button style={{ padding: '10px 20px', background: '#007bff', color: '#fff', border: 'none', cursor: 'pointer', alignSelf: 'center' }}>
                        Zaloguj
                    </button>
                </div>

                {/* Główna sekcja */}
                <div style={{ flexGrow: 1, padding: '20px' }}>
                    {selectedCar ? (
                        <div>
                            <div style={{ background: '#fafafa', padding: '20px', border: '1px solid blue', borderRadius: '5px', marginBottom: '20px' }}>
                                <h2>{selectedCar.name}</h2>
                                <p><strong>Rok produkcji:</strong> {selectedCar.year}</p>
                                <p><strong>Koszt:</strong> {selectedCar.cost}</p>
                            </div>

                            <div style={{ background: '#fff', padding: '20px', border: '1px solid blue', borderRadius: '5px' }}>
                                <h3>Historia kosztów</h3>
                                {costHistory[selectedCar.id].length > 0 ? (
                                    <ul style={{ listStyle: 'none', padding: 0 }}>
                                        {costHistory[selectedCar.id].map((entry) => (
                                            <li key={entry.id} style={{ padding: '10px', borderBottom: '1px solid #eee' }}>
                                                <p><strong>Typ:</strong> {entry.type}</p>
                                                <p><strong>Kwota:</strong> {entry.amount}</p>
                                                <p><strong>Data:</strong> {entry.date}</p>
                                            </li>
                                        ))}
                                    </ul>
                                ) : (
                                    <p>Brak historii kosztów dla tego auta.</p>
                                )}

                                {/* Przykładowy przycisk do dodawania kosztów */}
                                <button
                                    style={{ marginTop: '10px', padding: '10px 20px', background: '#28a745', color: '#fff', border: 'none', cursor: 'pointer' }}
                                    onClick={() => {
                                        const newCost = {
                                            id: Date.now(),
                                            type: 'Tankowanie',
                                            amount: '150 PLN',
                                            date: new Date().toISOString().split('T')[0],
                                        };
                                        addCost(selectedCar.id, newCost);
                                    }}
                                >
                                    Dodaj tankowanie
                                </button>
                            </div>
                        </div>
                    ) : (
                        <h2>Wybierz auto, aby zobaczyć szczegóły</h2>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Cars;
