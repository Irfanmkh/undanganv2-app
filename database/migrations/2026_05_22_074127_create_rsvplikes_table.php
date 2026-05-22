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
        Schema::create('rsvplikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rsvp_id')->constrained()->onDelete('cascade');
            $table->string("guest_token");

            $table->unique(['rsvp_id', 'guest_token']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvplikes');
    }
};
