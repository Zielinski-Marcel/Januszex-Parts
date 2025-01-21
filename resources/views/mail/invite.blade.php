<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; text-align: center;">

<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background: #ffffff; border: 2px solid #2ECC71; border-radius: 8px; padding: 20px; margin: 20px auto;">
    <tr>
        <td>
            <h2 style="color: #2ECC71; margin: 0 0 20px;">Zaproszenie do współdzielenia pojazdu</h2>
            <p style="font-size: 16px; color: #555555; margin: 0 0 20px; line-height: 1.6;">
                Cześć, <strong>{{ $user->name }}!</strong><br>
                <strong>{{ $invitor->name }}</strong> zaprosił Cię do współdzielenia pojazdu!
            </p>
            <h3 style="text-align: left; color: #2ECC71; margin: 0 0 10px;">Szczegóły pojazdu:</h3>
            <table align="center" style="text-align: left; font-size: 16px; color: #555555; margin: 10px auto;">
                <tr>
                    <td><strong>Marka:</strong></td>
                    <td>{{ $vehicle->brand }}</td>
                </tr>
                <tr>
                    <td><strong>Model:</strong></td>
                    <td>{{ $vehicle->model }}</td>
                </tr>
                <tr>
                    <td><strong>Rocznik:</strong></td>
                    <td>{{ $vehicle->year_of_manufacture }}</td>
                </tr>
            </table>
            <a href="{{ url('/invites') }}" style="display: inline-block; background-color: #2ECC71; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-size: 16px; font-weight: bold; margin: 20px 0;">
                Zobacz zaproszenie
            </a>
            <p style="font-size: 14px; color: #888888; margin: 20px 0; text-align: left;">
                Dziękujemy,<br> HKS
            </p>
        </td>
    </tr>
</table>

</body>
</html>
