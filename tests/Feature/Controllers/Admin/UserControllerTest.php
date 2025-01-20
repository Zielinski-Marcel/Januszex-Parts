<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_user_store_validation_failure()
    {
        // Tworzymy administratora i logujemy się
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        // Przesyłamy błędne dane (np. pusty email)
        $invalidData = [
            'name' => 'New User',
            'email' => '', // Błędny email
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ];

        // Wykonujemy żądanie POST do stworzenia użytkownika
        $response = $this->post(route('admin.users.store'), $invalidData);

        // Sprawdzamy, czy nie doszło do dodania użytkownika w bazie
        $this->assertDatabaseMissing('users', [
            'email' => '',
        ]);

        // Sprawdzamy, czy pozostały jakieś błędy w walidacji
        $response->assertSessionHasErrors(['email']);
    }
    #[Test]
    public function test_user_update()
    {
        // Tworzymy administratora, który będzie zalogowany
        $admin = User::factory()->create(['is_admin' => true]);

        // Tworzymy użytkownika, którego dane będą aktualizowane
        $user = User::factory()->create();

        // Zalogowanie się jako admin
        $this->actingAs($admin);

        // Dane, które będą użyte do aktualizacji
        $updatedData = [
            'name' => 'Updated User Name',
            'email' => 'updateduser@example.com',
        ];

        // Wykonujemy żądanie PATCH, aby zaktualizować dane użytkownika
        $response = $this->patch(route('admin.users.update', $user->id), $updatedData);

        // Sprawdzamy, czy użytkownik został zaktualizowany w bazie
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated User Name',
            'email' => 'updateduser@example.com',
        ]);

        // Sprawdzamy, czy użytkownik został przekierowany na stronę główną administratora
        $response->assertRedirect('/admin');

        // Sprawdzamy, czy w wiadomości sesji znajduje się odpowiedni komunikat
        $response->assertSessionHas('status', 'User updated successfully.');

        // Sprawdzamy, czy została zapisana aktywność w logach
        $this->assertDatabaseHas('activity_log', [
            'causer_id' => $admin->id,
            'subject_id' => $user->id,
            'description' => 'Updated user information.',
        ]);
    }

    #[Test]
    public function test_user_update_validation_failure()
    {
        // Tworzymy administratora i użytkownika
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        // Zalogowanie się jako admin
        $this->actingAs($admin);

        // Przesyłamy błędne dane (np. pusty email)
        $invalidData = [
            'name' => 'Updated User Name',
            'email' => '', // Zły email
        ];

        // Próba zaktualizowania użytkownika
        $response = $this->patch(route('admin.users.update', $user->id), $invalidData);

        // Sprawdzamy, czy nie doszło do zmiany w bazie danych
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => 'Updated User Name',
            'email' => '',
        ]);

        // Sprawdzamy, czy użytkownik pozostał na tej samej stronie
        $response->assertSessionHasErrors(['email']);
    }
    #[Test]
    public function test_user_edit()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get(route('admin.users.edit', $user->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function test_user_destroy()
    {
        // Tworzymy administratora, który będzie zalogowany
        $admin = User::factory()->create(['is_admin' => true]);

        // Tworzymy użytkownika, który będzie usunięty
        $user = User::factory()->create();

        // Zalogowanie się jako admin
        $this->actingAs($admin);

        // Wykonujemy żądanie DELETE, aby usunąć użytkownika
        $response = $this->delete(route('admin.users.destroy', $user->id));

        // Sprawdzamy, czy użytkownik został usunięty z bazy
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        // Sprawdzamy, czy użytkownik został przekierowany na stronę główną administratora
        $response->assertRedirect('/admin');

        // Sprawdzamy, czy w wiadomości sesji znajduje się odpowiedni komunikat
        $response->assertSessionHas('status', 'User deleted successfully.');

        // Sprawdzamy, czy została zapisana aktywność w logach
        $this->assertDatabaseHas('activity_log', [
            'causer_id' => $admin->id,
            'subject_id' => $user->id,
            'description' => 'Deleted a user.',
        ]);
    }
}
