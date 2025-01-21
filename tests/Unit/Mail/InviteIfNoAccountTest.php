<?php

namespace Tests\Unit\Mail;

use App\Mail\InviteIfNoAccount;
use App\Models\User;
use App\Models\Vehicle;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InviteIfNoAccountTest extends TestCase
{
    #[Test]
    public function test_invite_if_no_account_email_content()
    {
        // Tworzenie przykładowych danych
        $email = 'test@example.com';
        $invitor = User::factory()->make();
        $vehicle = Vehicle::factory()->make();

        // Tworzenie instancji maila
        $mail = new InviteIfNoAccount($email, $invitor, $vehicle);

        // Testowanie nagłówków wiadomości (envelope)
        $this->assertEquals('Invite', $mail->envelope()->subject);

        // Pobieranie danych zawartości wiadomości (content)
        $content = $mail->content();

        // Testowanie widoku
        $this->assertEquals('mail.inviteIfNoAccount', $content->view);

        // Testowanie danych przekazanych do widoku
        $this->assertArrayHasKey('invitor', $content->with);
        $this->assertArrayHasKey('vehicle', $content->with);

        // Sprawdzanie wartości zmiennych w widoku
        $this->assertEquals($invitor, $content->with['invitor']);
        $this->assertEquals($vehicle, $content->with['vehicle']);
    }
}
