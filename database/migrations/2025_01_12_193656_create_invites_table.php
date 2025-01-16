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
        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invitor_id');
            $table->unsignedBigInteger('invitee_id')->nullable();
            $table->string('email');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('status')->default('pending');
            $table->timestamps();


            $table->foreign('invitor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invitee_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
