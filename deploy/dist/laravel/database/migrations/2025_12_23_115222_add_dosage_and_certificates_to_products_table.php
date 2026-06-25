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
            $table->longText('dosage_info')->nullable()->after('usage_areas');
            $table->string('registration_certificate', 500)->nullable()->after('brochure_pdf');
            $table->string('label_certificate', 500)->nullable()->after('registration_certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['dosage_info', 'registration_certificate', 'label_certificate']);
        });
    }
};