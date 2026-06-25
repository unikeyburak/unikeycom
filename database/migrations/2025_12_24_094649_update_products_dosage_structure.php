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
        Schema::table('products', function (Blueprint $table) {
            // Yeni yapılandırılmış alanlar ekle
            $table->json('dosage_items')->nullable()->after('dosage_info');
            $table->json('application_info')->nullable()->after('dosage_items');
            $table->json('warning_info')->nullable()->after('application_info');
            $table->json('mixing_info')->nullable()->after('warning_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['dosage_items', 'application_info', 'warning_info', 'mixing_info']);
        });
    }
};