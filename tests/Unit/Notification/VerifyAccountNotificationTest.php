<?php

namespace Tests\Unit\Notification;

use App\Models\User;
use App\Notifications\VerifyAccountNotification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VerifyAccountNotificationTest extends TestCase
{
    #[Test]
    public function it_sends_verification_email()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Fake'ujemy wysyłanie powiadomień
        Notification::fake();

        // Wysyłamy powiadomienie
        $user->notify(new VerifyAccountNotification());

        // Sprawdzamy, czy powiadomienie zostało wysłane
        Notification::assertSentTo(
            [$user],
            VerifyAccountNotification::class
        );

        // Sprawdzamy, czy e-mail został wysłany z odpowiednim tematem
        Notification::assertSentTo($user, VerifyAccountNotification::class, function ($notification, $channels) use ($user) {
            // Zmieniliśmy, by przekazać $user
            return $notification->toMail($user)->subject === 'Weryfikacja konta HKS';
        });
    }
}
