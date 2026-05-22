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
        Schema::create('rsvpreplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->onDelete("cascade");
            $table->foreignId("rsvp_id")->constrained()->onDelete("cascade");
            $table->string("nama_pembalas")->required();
            $table->string("guest_token")->nullable();
            $table->string("pesan_reply")->required();
            $table->integer("like_count")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvpreplies');
    }
};
