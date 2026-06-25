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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 255);
            $table->string('tax_number', 50)->unique();
            $table->string('tax_office', 100);
            $table->string('phone', 20);
            $table->string('email', 100)->unique();
            $table->string('website', 255)->nullable();
            $table->text('address');
            $table->string('city', 100);
            $table->string('district', 100);
            $table->string('postal_code', 10)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('about')->nullable();
            $table->json('working_hours')->nullable();
            $table->json('social_media')->nullable();
            $table->enum('status', ['pending', 'active', 'inactive', 'suspended'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('suspension_reason')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamps();
            
            // İndeksler
            $table->index('company_name');
            $table->index('tax_number');
            $table->index('email');
            $table->index('city');
            $table->index('district');
            $table->index('status');
            $table->index(['latitude', 'longitude']);
            
            // Foreign keys
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};