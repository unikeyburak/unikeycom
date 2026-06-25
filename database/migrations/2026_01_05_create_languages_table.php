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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->unique(); // tr, en, fr, es, ar
            $table->string('name'); // Türkçe, English, Français
            $table->string('native_name'); // Türkçe, English, Français
            $table->string('flag')->nullable(); // bayrak ikonu
            $table->string('direction')->default('ltr'); // ltr veya rtl (Arapça için)
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('date_format')->nullable(); // tarih formatları
            $table->json('currency')->nullable(); // para birimi ayarları
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};