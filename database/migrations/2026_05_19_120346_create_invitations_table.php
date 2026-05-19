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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            // identitas
            $table->string('fullname_pria')->nullable();
            $table->string('nickname_pria')->nullable();
            $table->string('fullname_wanita')->nullable();
            $table->string('nickname_wanita')->nullable();
            $table->string('ayah_pria')->nullable();
            $table->string('ibu_pria')->nullable();
            $table->string('ayah_wanita')->nullable();
            $table->string('ibu_wanita')->nullable();

            // tema
            $table->string('tema')->nullable()->default('normal');

            // acara
            $table->dateTime('waktu_resepsi')->nullable();
            $table->dateTime('waktu_akad')->nullable();
            $table->string('lokasi_akad')->nullable();
            $table->string('lokasi_resepsi')->nullable();
            $table->string('link_map_akad')->nullable();
            $table->string('link_map_resepsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
