<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->primary(['category_id', 'product_id']);
            $table->index('product_id');
            $table->index(['product_id', 'is_primary']);

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // Mevcut category_id verilerini pivot tabloya kopyala
        DB::statement("
            INSERT INTO category_product (category_id, product_id, is_primary, created_at, updated_at)
            SELECT category_id, id, 1, NOW(), NOW()
            FROM products
            WHERE category_id IS NOT NULL
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
