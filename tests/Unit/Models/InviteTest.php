<?php

namespace Tests\Unit\Models;

use App\Models\Invite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InviteTest extends TestCase
{
    use RefreshDatabase;


    #[Test]
    public function invite_belongs_to_invitor()
    {
        $invitor = User::factory()->create();
        $invite = Invite::factory()->create(['invitor_id' => $invitor->id]);

        $this->assertInstanceOf(User::class, $invite->invitor);
        $this->assertEquals($invitor->id, $invite->invitor->id);
    }

    #[Test]
    public function invite_belongs_to_vehicle()
    {
        $vehicle = Vehicle::factory()->create();
        $invite = Invite::factory()->create(['vehicle_id' => $vehicle->id]);

        $this->assertInstanceOf(Vehicle::class, $invite->vehicle);
        $this->assertEquals($vehicle->id, $invite->vehicle->id);
    }
}
