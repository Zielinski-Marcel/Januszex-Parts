import React, { useState } from 'react';

const Cars = () => {
    // Lista aut
    const cars = [
        { id: 1, name: 'Toyota Corolla', year: 2015, cost: '50,000 PLN' },
        { id: 2, name: 'Ford Focus', year: 2018, cost: '60,000 PLN' },
        { id: 3, name: 'BMW 320i', year: 2020, cost: '120,000 PLN' },
    ];

    // Stan wybranego auta
    const [selectedCar, setSelectedCar] = useState(null);

    return (
        <div style={{ display: 'flex', height: '100vh' }}>
            {/* Lewy panel */}
            <div style={{ width: '250px', background: '#f4f4f4', padding: '20px', borderRight: '1px solid #ccc' }}>
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
                <button style={{ marginTop: '20px', padding: '10px 20px', background: '#007bff', color: '#fff', border: 'none', cursor: 'pointer' }}>
                    Zaloguj
                </button>
            </div>

            {/* Główna sekcja */}
            <div style={{ flexGrow: 1, padding: '20px' }}>
                {selectedCar ? (
                    <div style={{ background: '#fafafa', padding: '20px', border: '1px solid #ddd', borderRadius: '5px' }}>
                        <h2>{selectedCar.name}</h2>
                        <p><strong>Rok produkcji:</strong> {selectedCar.year}</p>
                        <p><strong>Koszt:</strong> {selectedCar.cost}</p>
                    </div>
                ) : (
                    <h2>Wybierz auto, aby zobaczyć szczegóły</h2>
                )}
            </div>
        </div>
    );
};

export default Cars;
