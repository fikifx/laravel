<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('term_settings', function (Blueprint $table) {
            $table->id();
            $table->json('lepas_kunci_items')->nullable();
            $table->json('dengan_sopir_items')->nullable();
            $table->integer('overtime_percentage')->default(10);
            $table->string('overtime_desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('term_settings');
    }
};
