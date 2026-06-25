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
        Schema::table('categories', function (Blueprint $table) {
            // Description alanı yoksa ekle, varsa LONGTEXT'e çevir
            if (!Schema::hasColumn('categories', 'description')) {
                $table->longText('description')->nullable()->after('slug');
            } else {
                // Mevcut alanı LONGTEXT'e çevir
                $table->longText('description')->nullable()->change();
            }
            
            // SEO için ek alan
            if (!Schema::hasColumn('categories', 'description_plain')) {
                $table->text('description_plain')->nullable()->after('description')
                    ->comment('HTML içermeyen düz metin versiyonu');
            }
            
            // Sıralama alanı
            if (!Schema::hasColumn('categories', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('status');
                $table->index('sort_order');
            }
            
            // Kategori resmi
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('description_plain');
            }
            
            // Aktiflik
            if (!Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
                $table->index('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['description_plain', 'sort_order', 'image', 'is_active']);
        });
    }
};