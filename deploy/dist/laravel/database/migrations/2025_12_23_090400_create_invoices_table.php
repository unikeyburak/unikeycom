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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50)->unique();
            $table->string('serial', 10);
            $table->integer('sequence');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('dealer_id');
            $table->date('invoice_date');
            $table->time('invoice_time');
            $table->json('seller_info');
            $table->json('buyer_info');
            $table->json('items');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_total', 10, 2)->default(0);
            $table->decimal('tax_base', 12, 2);
            $table->json('tax_details');
            $table->decimal('tax_total', 10, 2);
            $table->decimal('grand_total', 12, 2);
            $table->string('total_in_words', 255);
            $table->string('currency', 3)->default('TRY');
            $table->decimal('exchange_rate', 10, 4)->default(1);
            $table->enum('type', ['sales', 'return', 'proforma'])->default('sales');
            $table->enum('status', ['draft', 'approved', 'cancelled'])->default('approved');
            $table->string('pdf_path', 255)->nullable();
            $table->string('e_invoice_uuid', 100)->nullable();
            $table->timestamp('e_invoice_date')->nullable();
            $table->enum('e_invoice_status', ['pending', 'sent', 'approved', 'rejected'])->nullable();
            $table->text('e_invoice_response')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            
            // İndeksler
            $table->index('invoice_number');
            $table->index('order_id');
            $table->index('dealer_id');
            $table->index('invoice_date');
            $table->index('type');
            $table->index('status');
            $table->index(['serial', 'sequence']);
            $table->index('e_invoice_uuid');
            
            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};