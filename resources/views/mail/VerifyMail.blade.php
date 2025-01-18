<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weryfikacja konta</title>
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
</head>
<body>
<div class="email-container">
    <h2>Witaj w HKS, {{ $user->name }}!</h2>
    <p>Aby zweryfikować swoje konto, kliknij w przycisk poniżej:</p>
    <a href="{{$verificationLink}}" class="verification-button">Zweryfikuj</a>
    <p class="footer">Życzymy miłego korzystania z naszej aplikacji!</p>
</div>
</body>
</html>
