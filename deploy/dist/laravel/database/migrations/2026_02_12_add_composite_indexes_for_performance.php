<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Mega menu ve navigasyon sorgulari icin composite index
            // WHERE parent_id IS NULL AND status = 'active' ORDER BY name
            // WHERE status = 'active' ORDER BY name
            $table->index(['status', 'parent_id', 'name'], 'categories_status_parent_name_index');
        });

        Schema::table('settings', function (Blueprint $table) {
            // group bazli sorgular icin
            $table->index(['group', 'key'], 'settings_group_key_index');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_status_parent_name_index');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex('settings_group_key_index');
        });
    }
};
