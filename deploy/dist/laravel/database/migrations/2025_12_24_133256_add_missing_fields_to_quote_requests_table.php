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
        Schema::table('quote_requests', function (Blueprint $table) {
            // Teslimat bilgileri
            $table->string('delivery_city', 100)->nullable()->after('unit');
            $table->date('delivery_date')->nullable()->after('delivery_city');
            
            // Kullanım ve ödeme bilgileri
            $table->string('usage_purpose')->nullable()->after('delivery_date');
            $table->enum('payment_method', ['Nakit', 'Vadeli', 'Kredi Kartı', 'Havale/EFT'])->nullable()->after('usage_purpose');
            
            // Durum geçmişi (JSON formatında)
            $table->json('status_history')->nullable()->after('admin_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_city',
                'delivery_date', 
                'usage_purpose',
                'payment_method',
                'status_history'
            ]);
        });
    }
};
