<!DOCTYPE html>
<html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .email-container {
        max-width: 600px;
        background: #ffffff;
        border: 2px solid #2ECC71;
        border-radius: 8px;
        text-align: center;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .email-container h2 {
        color: #2ECC71;
        margin-bottom: 20px;
    }
    .email-container p {
        font-size: 16px;
        color: #555555;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .verification-button {
        display: inline-block;
        background-color: #2ECC71;
        color: #ffffff;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .verification-button:hover {
        background-color: #28A65E;
    }
    .footer {
        margin-top: 20px;
        font-size: 14px;
        color: #888888;
    }
    </style>
<div class="email-container">
    <h2>Zaproszenie do współdzielenia pojazdu</h2>
    <p>Cześć,<strong> {{ $user->name }}!</strong></p>
    <p><strong>{{ $invitor->name }}</strong> zaprosił Cię do współdzielenia pojazdu!</p>
    <h3 style="text-align: left;">Szczegóły pojazdu:</h3>
    <ul>
        <li><strong>Marka:</strong> {{ $vehicle->brand }}</li>
        <li><strong>Model:</strong> {{ $vehicle->model }}</li>
        <li><strong>Rocznik:</strong> {{ $vehicle->year_of_manufacture }}</li>
    </ul>
    <div style="text-align: center;">
        <a href="{{ url('/invites') }}" class="verification-button">Zobacz zaproszenie</a>
    </div>
    <p></p>
    <p class="footer" style="text-align: left">Dziękujemy,<br> HKS</p>
</div>
</html>
