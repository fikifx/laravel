<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->nullable();         // "Rating 4.8/5 · 2000+ Pelanggan Puas"
            $table->string('headline')->nullable();           // "Sewa Mobil"
            $table->string('headline_highlight')->nullable(); // "Banyuwangi"
            $table->string('headline_suffix')->nullable();    // "Murah"
            $table->string('subheadline')->nullable();        // "Lepas Kunci & Dengan Sopir"
            $table->text('description')->nullable();          // Paragraf deskripsi
            $table->string('cta_primary_text')->nullable();   // "Lihat Semua Armada"
            $table->string('cta_primary_url')->nullable();    // "#armada"
            $table->string('cta_secondary_text')->nullable(); // "Konsultasi Gratis"
            $table->string('whatsapp_number')->nullable();    // "6282339333202"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
