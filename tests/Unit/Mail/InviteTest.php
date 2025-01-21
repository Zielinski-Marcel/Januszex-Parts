<?php

namespace Tests\Unit\Mail;

use App\Mail\Invite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InviteTest extends TestCase
{
    #[Test]
    public function test_invite_email_with_factories()
    {
        // Tworzenie danych za pomocą fabryk
        $invitor = User::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();
        $token = 'exampleToken123';

        // Tworzenie e-maila z użyciem tych danych
        $mail = new \App\Mail\Invite($user, $invitor, $vehicle, $token);

        // Testowanie nagłówków
        $this->assertEquals('Invite', $mail->envelope()->subject);

        // Testowanie zmiennych w widoku
        $content = $mail->content();
        $this->assertEquals('mail.invite', $content->view);

        // Testowanie zawartości przekazanych danych
        $this->assertEquals($invitor, $content->with['invitor']);
        $this->assertEquals($user, $content->with['user']);
        $this->assertEquals($vehicle, $content->with['vehicle']);
        $this->assertEquals('Pending', $content->with['status']);
        $this->assertEquals($token, $content->with['token']);
    }

}
