<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_vehicle', function (Blueprint $table) {
            $table->id(); // Klucz główny
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Powiązanie z użytkownikami
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // Powiązanie z pojazdami
            $table->string('role'); // Rola: 'owner' lub 'shared'
            $table->string('status'); // Status: 'pending', 'accepted', 'rejected'
            $table->timestamps(); // Znaczniki czasu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle');
    }
};
