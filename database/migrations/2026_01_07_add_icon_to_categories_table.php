<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('description'); // Font Awesome icon class
            $table->string('icon_image')->nullable()->after('icon'); // Custom icon image
            $table->boolean('show_on_homepage')->default(false)->after('is_active');
            $table->integer('homepage_order')->default(0)->after('show_on_homepage');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['icon', 'icon_image', 'show_on_homepage', 'homepage_order']);
        });
    }
};