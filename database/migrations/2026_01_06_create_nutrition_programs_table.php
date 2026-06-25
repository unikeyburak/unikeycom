<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Bitkiler tablosu
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('scientific_name')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_active');
        });
        
        // Bitki besleme programları
        Schema::create('nutrition_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plant_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('season')->nullable(); // İlkbahar, Yaz, Sonbahar, Kış
            $table->string('growth_stage')->nullable(); // Fide, Vejetatif, Çiçeklenme, Meyve
            $table->string('application_area')->nullable(); // Yaprak, Toprak, Damlama
            $table->json('climate_conditions')->nullable(); // Sıcaklık, nem vs.
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('plant_id')->references('id')->on('plants')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['plant_id', 'status']);
        });
        
        // Program aşamaları (stages)
        Schema::create('nutrition_program_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->string('title');
            $table->integer('stage_order')->default(0);
            $table->string('timing')->nullable(); // Örn: "Ekimden 15 gün sonra"
            $table->string('duration')->nullable(); // Örn: "7-10 gün"
            $table->text('description')->nullable();
            $table->json('notes')->nullable(); // Önemli notlar
            $table->timestamps();
            
            $table->foreign('program_id')->references('id')->on('nutrition_programs')->cascadeOnDelete();
            $table->index('program_id');
        });
        
        // Program-Ürün ilişkisi
        Schema::create('nutrition_program_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('product_id');
            $table->string('dosage'); // Dozaj bilgisi
            $table->string('application_method')->nullable(); // Uygulama şekli
            $table->string('frequency')->nullable(); // Uygulama sıklığı
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('stage_id')->references('id')->on('nutrition_program_stages')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->index(['stage_id', 'product_id']);
        });
        
        // Program sonuçları/faydaları
        Schema::create('nutrition_program_benefits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('program_id')->references('id')->on('nutrition_programs')->cascadeOnDelete();
            $table->index('program_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nutrition_program_benefits');
        Schema::dropIfExists('nutrition_program_products');
        Schema::dropIfExists('nutrition_program_stages');
        Schema::dropIfExists('nutrition_programs');
        Schema::dropIfExists('plants');
    }
};