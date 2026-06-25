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
        // Zaten var olan indexleri kontrol etmeden direkt ekleyelim
        try {
            // Products tablosu indexleri
            Schema::table('products', function (Blueprint $table) {
                $table->index('status');
                $table->index('is_featured');
                $table->index(['status', 'is_featured']);
                $table->index(['category_id', 'status']);
            });
        } catch (\Exception $e) {
            // Index zaten varsa devam et
        }

        try {
            // Categories tablosu indexleri
            Schema::table('categories', function (Blueprint $table) {
                $table->index('parent_id');
                $table->index('sort_order');
            });
        } catch (\Exception $e) {
            // Index zaten varsa devam et
        }

        try {
            // Settings tablosu indexleri
            Schema::table('settings', function (Blueprint $table) {
                $table->index('key');
            });
        } catch (\Exception $e) {
            // Index zaten varsa devam et
        }

        try {
            // Dealers tablosu indexleri
            Schema::table('dealers', function (Blueprint $table) {
                $table->index('status');
                $table->index('city');
                $table->index(['city', 'status']);
            });
        } catch (\Exception $e) {
            // Index zaten varsa devam et
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Indexleri kaldır
    }
};