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
        $driver = Schema::getConnection()->getDriverName();

        Schema::create('products', function (Blueprint $table) use ($driver) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('sku', 100)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('active_ingredient', 255)->nullable();
            $table->string('formulation', 255)->nullable();
            $table->text('usage_areas')->nullable();
            $table->json('technical_info')->nullable();
            $table->json('images')->nullable();
            $table->string('brochure_pdf', 500)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // İndeksler
            $table->index('category_id');
            $table->index('slug');
            $table->index('sku');
            $table->index('status');
            if ($driver !== 'sqlite') {
                $table->fullText(['name', 'short_description', 'long_description']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
