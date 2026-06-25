<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Sadece hâlâ eski değerdeyse güncelle — admin panelinden zaten değiştirildiyse dokunma
        DB::table('settings')
            ->where('key', 'site_name')
            ->where('value', 'Unikeyterra')
            ->update(['value' => 'Keysol Agro']);

        // footer_copyright henüz Unikeyterra içeriyorsa güncelle
        DB::table('settings')
            ->where('key', 'footer_copyright')
            ->where('value', 'like', '%Unikeyterra%')
            ->update(['value' => '© ' . date('Y') . ' Keysol Agro. Tüm hakları saklıdır.']);
    }

    public function down(): void
    {
        DB::table('settings')
            ->where('key', 'site_name')
            ->where('value', 'Keysol Agro')
            ->update(['value' => 'Unikeyterra']);
    }
};
