<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\QuoteRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    // Polling KAPALI — shared hosting'de timeout riski
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Dashboard istatistiklerini 5 dk cache'le (8 sorgu yerine 0)
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'product_total' => Product::count(),
                'product_active' => Product::where('status', 'active')->count(),
                'category_total' => Category::count(),
                'category_active' => Category::where('status', 'active')->count(),
                'dealer_total' => Dealer::count(),
                'dealer_active' => Dealer::where('status', 'active')->count(),
                'quote_pending' => QuoteRequest::where('status', 'pending')->count(),
                'quote_month' => QuoteRequest::whereMonth('created_at', now()->month)->count(),
            ];
        });

        return [
            Stat::make('Toplam Ürün', $stats['product_total'])
                ->description('Aktif: ' . $stats['product_active'])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Toplam Kategori', $stats['category_total'])
                ->description('Aktif: ' . $stats['category_active'])
                ->descriptionIcon('heroicon-m-folder')
                ->color('primary'),

            Stat::make('Toplam Bayi', $stats['dealer_total'])
                ->description('Aktif: ' . $stats['dealer_active'])
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => '$dispatch("setPage", "dealers")',
                ]),

            Stat::make('Bekleyen Teklifler', $stats['quote_pending'])
                ->description('Bu ay: ' . $stats['quote_month'])
                ->descriptionIcon('heroicon-m-document-text')
                ->color('danger'),
        ];
    }
}
