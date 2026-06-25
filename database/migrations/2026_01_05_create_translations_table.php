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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->morphs('translatable'); // product, category, page vb.
            $table->string('language_code', 5);
            $table->string('field'); // name, description, meta_title vb.
            $table->longText('value')->nullable();
            $table->timestamps();
            
            $table->index(['translatable_type', 'translatable_id', 'language_code', 'field'], 'translations_index');
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};