# SEO Optimizasyon Dokümantasyonu

## Genel Bakış

Projede kapsamlı bir SEO altyapısı kurulmuştur. Bu dokümantasyon, SEO özelliklerinin nasıl kullanılacağını açıklar.

## 1. SEO Service ve Trait

### SEO Service (`app/Services/SeoService.php`)
- Meta tag yönetimi
- JSON-LD Schema oluşturma
- Canonical URL yönetimi
- Robots meta tag kontrolü
- Hreflang tag desteği

### HasSeo Trait (`app/Http/Traits/HasSeo.php`)
Product, Category ve Page modellerine eklenebilir:

```php
use App\Http\Traits\HasSeo;

class Product extends Model
{
    use HasSeo;
}
```

## 2. Meta Tag Yönetimi

### Controller'da Kullanım
```php
public function show($slug)
{
    $product = Product::findBySlug($slug);
    
    // SEO meta verilerini hazırla
    $meta = $product->getSeoMeta();
    $schema = $product->getSchemaJson();
    
    return view('products.show', compact('product', 'meta', 'schema'));
}
```

### Blade Template'de
```blade
@extends('layouts.app')

@section('title', $product->getSeoTitle())

{{-- Meta veriler otomatik olarak layout'tan alınır --}}
```

## 3. Schema.org Entegrasyonu

Desteklenen schema tipleri:
- Organization
- Product
- LocalBusiness
- BreadcrumbList
- WebSite

### Ürün Schema Örneği
```json
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "Ürün Adı",
  "description": "Ürün açıklaması",
  "image": "https://site.com/image.jpg",
  "sku": "SKU123",
  "brand": {
    "@type": "Brand",
    "name": "Unikeyterra"
  }
}
```

## 4. Sitemap

### Otomatik Sitemap Güncelleme
```bash
# Her gece 02:00'de çalışır
php artisan sitemap:generate
```

### Özellikler
- XML formatında
- Resim desteği
- Priority ve changefreq ayarları
- Otomatik güncelleme

## 5. Meta Tag Alanları

### Model'de Tanımlı Alanlar
- `meta_title` - SEO başlığı (max 60 karakter)
- `meta_description` - SEO açıklaması (max 160 karakter)
- `meta_keywords` - Anahtar kelimeler

### Otomatik Doldurma
Eğer meta alanları boşsa:
- Title: `name` veya `title` alanından alınır
- Description: `short_description` veya `description` alanından alınır
- Keywords: Kategori adı ve ürün adından oluşturulur

## 6. Open Graph Tags

Sosyal medya paylaşımları için:
- `og:title`
- `og:description`
- `og:image`
- `og:url`
- `og:type`
- `og:locale`
- `og:site_name`

## 7. Twitter Cards

Twitter paylaşımları için:
- `twitter:card` (summary_large_image)
- `twitter:title`
- `twitter:description`
- `twitter:image`

## 8. Robots.txt

`/public/robots.txt` dosyası:
- İzin verilen dizinler
- Engellenen dizinler
- Sitemap konumu
- Crawl-delay ayarları
- Googlebot özel kuralları

## 9. Canonical URLs

Duplicate content sorunlarını önlemek için:
```php
$seoService->generateCanonicalUrl($url);
```

## 10. SEO Best Practices

### URL Yapısı
- SEO-friendly sluglar
- Kategori hiyerarşisi
- Temiz URL'ler

### Performans
- Lazy loading images
- WebP formatı desteği
- Responsive images
- CDN entegrasyonu

### İçerik
- Unique meta açıklamalar
- Zengin içerik
- Alt text'ler
- Heading hiyerarşisi

## 11. SEO Kontrol Listesi

- [x] Meta tag yönetimi
- [x] Schema.org markup
- [x] XML Sitemap
- [x] Robots.txt
- [x] Canonical URLs
- [x] Open Graph tags
- [x] Twitter Cards
- [x] Responsive images
- [x] WebP desteği
- [x] CDN hazırlığı

## 12. Filament Admin Panel'de SEO

Admin panelde her ürün/sayfa için:
- Meta title alanı
- Meta description alanı
- Meta keywords alanı
- SEO preview özelliği eklenebilir

## Gelecek Geliştirmeler

1. SEO skor analizi
2. Meta tag önizleme
3. Otomatik keyword önerileri
4. Rich snippets desteği
5. AMP sayfalar
6. Çoklu dil SEO desteği