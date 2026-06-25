<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Faq;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class SeoOverviewWidget extends BaseWidget
{
    // Polling KAPALI — shared hosting'de her 30s'de 5 sorgu = timeout
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $stats = Cache::remember('admin_seo_stats', 300, function () {
            return [
                'without_meta' => Product::where(function ($query) {
                    $query->whereNull('meta_title')
                          ->orWhere('meta_title', '')
                          ->orWhereNull('meta_description')
                          ->orWhere('meta_description', '');
                })->count(),
                'with_faq' => Product::whereHas('faqs', function ($query) {
                    $query->where('is_active', true);
                })->count(),
                'total_products' => Product::count(),
                'total_faqs' => Faq::where('is_active', true)->count(),
                'featured' => Product::where('is_featured', true)->where('status', 'active')->count(),
            ];
        });

        return [
            Stat::make('Meta Eksik Ürünler', $stats['without_meta'])
                ->description('SEO optimizasyonu gerekli')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($stats['without_meta'] > 0 ? 'warning' : 'success')
                ->chart([7, 3, 4, 5, 6, 3, 5]),

            Stat::make('FAQ\'lı Ürünler', $stats['with_faq'] . '/' . $stats['total_products'])
                ->description('Rich snippet için hazır')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([3, 5, 6, 7, 8, 9, 10]),

            Stat::make('Toplam SSS', $stats['total_faqs'])
                ->description('Aktif soru-cevap')
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('info'),

            Stat::make('Öne Çıkan', $stats['featured'])
                ->description('Ana sayfada gösterilen')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}
