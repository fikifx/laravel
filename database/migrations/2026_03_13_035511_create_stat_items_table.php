<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stat_items', function (Blueprint $table) {
            $table->id();
            $table->string('label');          // "Unit Armada", "Tahun Berpengalaman", dll
            $table->unsignedInteger('target')->nullable(); // 50, 8, 2000 — null if fixed text
            $table->string('suffix')->nullable();          // "+", "%"
            $table->string('fixed_value')->nullable();     // "24/7" — if not a number
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stat_items');
    }
};
