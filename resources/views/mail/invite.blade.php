@component('mail::message')
    # Zaproszenie do współdzielenia pojazdu

    Cześć, {{ $user->name }}!

    {{ $invitor->name }} zaprosił Cię do współdzielenia pojazdu o nazwie: **{{ $vehicle->name }}**.

    ## Szczegóły pojazdu:
    - **Model:** {{ $vehicle->model }}
    - **Numer rejestracyjny:** {{ $vehicle->registration_number }}

    Status zaproszenia: **{{ ucfirst($status) }}**

    @component('mail::button', ['url' => url('/invites')])
        Zobacz zaproszenie
    @endcomponent
    Dziękujemy,<br>

    {{ config('app.name') }}
@endcomponent
