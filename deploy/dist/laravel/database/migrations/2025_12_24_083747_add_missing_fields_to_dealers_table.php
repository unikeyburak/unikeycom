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
        Schema::table('dealers', function (Blueprint $table) {
            $table->string('contact_name', 255)->nullable()->after('company_name');
            $table->string('whatsapp', 20)->nullable()->after('phone');
            $table->boolean('is_active')->default(false)->after('status');
            $table->boolean('is_verified')->default(false)->after('is_active');
            $table->decimal('credit_limit', 12, 2)->nullable()->default(0)->after('is_verified');
            $table->string('payment_terms', 20)->nullable()->default('0')->after('credit_limit');
            $table->text('notes')->nullable()->after('suspension_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->dropColumn([
                'contact_name',
                'whatsapp', 
                'is_active',
                'is_verified',
                'credit_limit',
                'payment_terms',
                'notes'
            ]);
        });
    }
};
