<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * products tablosuna eksik iki alan ekler:
 *   - features_text  (LONGTEXT)  Zengin metin tabanlı "özellikler/avantajlar" alanı
 *   - product_colors (JSON)      Ürün renk varyantları (ör. ambalaj renkleri)
 *
 * Bu alanlar modelde ve Filament formunda kullanılmasına rağmen migration eksikti.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'features_text')) {
                $table->longText('features_text')->nullable()->after('long_description');
            }
            if (!Schema::hasColumn('products', 'product_colors')) {
                $table->json('product_colors')->nullable()->after('packaging_sizes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'features_text')) {
                $table->dropColumn('features_text');
            }
            if (Schema::hasColumn('products', 'product_colors')) {
                $table->dropColumn('product_colors');
            }
        });
    }
};
