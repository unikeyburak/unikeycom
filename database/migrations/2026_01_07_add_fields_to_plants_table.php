<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->boolean('show_on_homepage')->default(true)->after('is_active');
            $table->integer('homepage_order')->default(0)->after('show_on_homepage');
            $table->string('icon')->nullable()->after('image'); // Font Awesome icon class
            $table->string('color_class')->default('green')->after('icon'); // Renk sınıfı
        });
    }

    public function down()
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->dropColumn(['show_on_homepage', 'homepage_order', 'icon', 'color_class']);
        });
    }
};