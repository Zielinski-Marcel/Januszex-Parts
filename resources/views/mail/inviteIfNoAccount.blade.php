@component('mail::message')
    # Zaproszenie do współdzielenia pojazdu

    Cześć!

    {{ $invitor->name }} zaprosił Cię do współdzielenia pojazdu o nazwie: **{{ $vehicle->name }}**.

    Załóż konto

    @component('mail::button', ['url' => url('/register')])
        Zarejestruj się
    @endcomponent

    Dziękujemy,<br>
    {{ config('app.name') }}
@endcomponent
