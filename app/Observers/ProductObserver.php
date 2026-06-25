<?php

namespace App\Observers;

use App\Http\Middleware\CachePublicPages;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Ürün oluşturulduğunda
     */
    public function created(Product $product): void
    {
        $this->clearCaches();
        // Sayfa cache'i ilk ziyarette otomatik oluşur — senkron warm yapmıyoruz (timeout riski)
    }

    /**
     * Ürün güncellendiğinde
     */
    public function updated(Product $product): void
    {
        $this->clearCaches();

        // Slug değiştiyse eski cache'i de sil
        if ($product->isDirty('slug')) {
            CachePublicPages::clearUrl('/urun/' . $product->getOriginal('slug'));
        }

        // Ürün sayfasının eski cache'ini sil (yeni cache ilk ziyarette oluşur)
        CachePublicPages::clearUrl('/urun/' . $product->slug);

        // Ürünün bağlı olduğu kategori sayfalarının cache'ini sil
        $this->clearCategoryCaches($product);
    }

    /**
     * Ürün silindiğinde
     */
    public function deleted(Product $product): void
    {
        $this->clearCaches();
        CachePublicPages::clearUrl('/urun/' . $product->slug);
    }

    /**
     * İlgili cache key'lerini temizle
     */
    private function clearCaches(): void
    {
        Cache::forget('featured_products');
        Cache::forget('homepage_categories');
        Cache::forget('homepage_stats');
        Cache::forget('homepage_plant_programs_grid');
        Cache::forget('admin_dashboard_stats');
        Cache::forget('mega_menu_categories');

        // Ana sayfa cache'ini temizle (yeni cache ilk ziyarette oluşur)
        CachePublicPages::clearUrl('/');
    }

    /**
     * Ürünün bağlı olduğu kategori sayfalarının page cache'ini temizle
     */
    private function clearCategoryCaches(Product $product): void
    {
        // Many-to-many kategoriler
        if ($product->relationLoaded('categories')) {
            foreach ($product->categories as $cat) {
                CachePublicPages::clearUrl('/' . $cat->slug);
            }
        }

        // Eski tek kategori ilişkisi
        if ($product->category) {
            CachePublicPages::clearUrl('/' . $product->category->slug);
        }
    }
}
