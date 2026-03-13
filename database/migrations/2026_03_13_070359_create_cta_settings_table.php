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
        Schema::create('cta_settings', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->string('wa_text');
            $table->string('wa_number');
            $table->string('catalog_text');
            $table->string('catalog_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cta_settings');
    }
};
