<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * products.status ENUM'una 'draft' değeri ekler.
 *
 * Form (Filament ProductResource) 'draft' | 'active' | 'inactive' sunuyor
 * ama DB şeması sadece 'active' | 'inactive' kabul ediyordu — bu tutarsızlığı giderir.
 */
return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('draft','active','inactive') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        // Önce draft kayıtları inactive'e çevir (enum daraltma sırasında veri kaybını önler)
        DB::statement("UPDATE products SET status = 'inactive' WHERE status = 'draft'");
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('active','inactive') NOT NULL DEFAULT 'active'");
    }
};
