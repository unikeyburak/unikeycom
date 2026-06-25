# Unikeyterra — Proje Denetim Raporu

**Tarih:** 2026-06-15
**Kapsam:** Tüm proje (mimari, güvenlik, performans, DB, kod kalitesi, frontend, SEO)
**Yöntem:** Çekirdek dosyalar birincil kaynaktan okunarak doğrulandı; geniş alanlar haritalandı.
**Önemli not:** "✅ Doğrulandı" işaretli maddeler dosya:satır kanıtıyla bizzat teyit edildi. "🔍 Harita" işaretli maddeler envanterdir, olgu değildir. Hiçbir kod değiştirilmedi.

---

## 1. Genel Değerlendirme

Laravel 12 + Filament 3 üzerine kurulu, **çok dilli (5 dil: en/tr/fr/ar/es)** agro-ürün kurumsal sitesi + B2B bayi paneli. Mimari **olgun ve bilinçli**:

- **Katmanlı tasarım**: Controller → Service → Repository (+ Contracts/interface) + DTO.
- **Çeviri sistemi**: Polymorphic `translations` tablosu + `Translatable` trait; eager-load farkında, cache'li (`translate()` `relationLoaded` kontrolü yapıyor).
- **SEO altyapısı**: `HasSeo` trait, JSON-LD schema, hreflang/og View Composer'da merkezi (`AppServiceProvider`), `config/seo.php` zengin.
- **Cache stratejisi**: ayarlar/menü/diller/öne çıkanlar cache'li; model observer'ları ile invalidasyon.
- **Güvenlik katmanı**: `SanitizeInput`, `SecurityHeaders`, `CachePublicPages` middleware'leri; kapsamlı RateLimiter tanımları; `trustProxies` (Cloudflare).
- **DB indeksleme**: gerçekte oldukça kapsamlı (composite index'ler mevcut — aşağıya bak).

Temel sağlam. İyileştirme alanları çoğunlukla **kırık bir B2B akışı, birkaç güvenlik sertleştirmesi, "şişkin" dosyalar ve sıfır test kapsamı** etrafında toplanıyor.

---

## 2. Teknoloji Yığını

| Katman | Teknoloji |
|---|---|
| Backend | PHP 8.2, Laravel 12 |
| Admin | Filament 3.2 (panel: `/admin`, yeşil tema, TR arayüz) |
| DB | MySQL (Docker `mysql` host), prod LiteSpeed + Cloudflare |
| Frontend build | Vite 7 + Tailwind CSS v4 (`@theme` token sistemi) + Alpine.js 3 |
| Görsel | Intervention Image 3, `MediaService` (responsive srcset) |
| Cache/Queue | Redis (predis) |
| Auth | Filament (`web` guard = admin, public kayıt YOK) + ayrı `dealer` guard (B2B) |

---

## 3. Modül Haritası (🔍 envanter)

- **Katalog**: Product (↔ Category hem `category_id` hem `category_product` pivot), Category (ağaç/parent_id), Catalog (PDF), Plant + NutritionProgram (Stage/Product/Benefit).
- **İçerik**: Page (statik), Post ↔ PostCategory ↔ PostTag (blog), Faq (polymorphic).
- **B2B**: Dealer ↔ DealerUser (ayrı guard), QuoteRequest, Order/Invoice (kısmen iskelet), ApiToken, ActivityLog.
- **Sistem**: Language, Translation, Setting (1095 satırlık merkezi Settings sayfasıyla yönetiliyor).
- **Filament**: 13 Resource, 2 Widget (StatsOverview/SeoOverview, 5dk cache), özel `TranslatableInput` form bileşeni, WordPress Import sayfası.

---

## 4. Bulgular — Önem Sırasına Göre

### 🔴 KRİTİK — Doğrulanmış gerçek hatalar

#### B1. Bayi ürün/teklif akışı kod düzeyinde KIRIK ✅ Doğrulandı
`products` tablosunda **`is_active` kolonu yok** (yalnızca `status` enum: active/inactive — `create_products_table.php:33`), Product modelinde de accessor/cast yok. Ama `DealerController` ürünleri `is_active` ile sorguluyor:
- `DealerController.php:375` → `Product::...->where('is_active', true)` → **"Unknown column 'is_active'" SQL hatası** → `/bayi/urunler` listesi çöker.
- `DealerController.php:422, 448, 460` → `if (!$product->is_active)` → yok olan attribute `null` döner → `if(!null)` hep `true` → **bayi ürün detay / teklif formu / teklif gönderimi sayfaları HER ZAMAN 404**.

**Sonuç:** Giriş yapmış bayinin ürün gezme + teklif isteme akışının tamamı çalışmıyor. (Etki: B2B'nin çekirdek işlevi.)
**Çözüm yönü:** Bu sorguları `where('status', 'active')` / `$product->status === 'active'` ile düzeltmek. (Frontend zaten `status` kullanıyor.)

#### B2. `categories` tablosunda çift "aktiflik" konvansiyonu ✅ Doğrulandı
`categories` tablosunda hem `status` enum (`create_categories_table.php:21`) hem `is_active` boolean (`add_description_to_categories_table.php:42`) var. Frontend `where('status','active')` (örn. `AppServiceProvider:149`), bayi tarafı `where('is_active', true)` (`DealerController.php:409`) kullanıyor. İkisi senkron tutulmazsa kategori bir yerde görünüp diğerinde kaybolur. (Çökme değil, veri tutarlılığı riski.)
**Çözüm yönü:** Tek kaynağa indirgemek (tercihen `status`), diğerini accessor'a/deprecate'e çekmek.

#### B3. Korumasız cache-rebuild rotası — her ortamda açık ✅ Doğrulandı
`web.php:31` → `GET /optimize-clear-cache-2024x` kimlik doğrulaması yok, `environment()` guard'ı yok (debug rotalarının aksine — onlar `if (app()->environment('local'))` içinde, satır 52). Herkes çağırıp cache/route/view rebuild tetikleyebilir (yük/DoS yüzeyi). Kodun kendi yorumu: *"geçici, kullandıktan sonra sil"*.
**Çözüm yönü:** Kaldırmak veya en azından `auth` + `local` arkasına almak; ihtiyaç varsa artisan komutu olarak bırakmak.

---

### 🟠 YÜKSEK — Doğrulanmış, etkisi yüksek

#### B4. Teklif gönderimine rate limit uygulanmamış ✅ Doğrulandı
`AppServiceProvider:328`'de `quote-request` limiter **tanımlı** ama `web.php:373` `dealer.products.quote.submit` rotasına **uygulanmamış**. Tanımlı ama bağlanmamış bir limiter. (Bayi auth arkasında olduğu için risk sınırlı, yine de spam'e açık.)

#### B5. İlgili ürünlerde olası N+1 ✅ Doğrulandı (kod örüntüsü)
`ProductRepository::getRelatedProducts()` (`satır 150-151`) `with($relations)` kullanıyor ama diğer tüm metotların aksine `category.translations`'ı **eklemiyor** (krş. satır 37, 51, 80, 114, 169). İlgili ürün kartları kategori adını `translate()` ile gösteriyorsa her ürün için ek sorgu çıkar.

#### B6. Sıfır test kapsamı ✅ Doğrulandı
`tests/Feature` ve `tests/Unit` yalnızca `ExampleTest` içeriyor. **Proje git deposu da değil** → regresyon güvenlik ağı sıfır. B1 gibi kırık akışlar bu yüzden fark edilmemiş olabilir.

---

### 🟡 ORTA — Kod kalitesi / ölçeklenme

| # | Bulgu | Kanıt | Not |
|---|---|---|---|
| B7 | "Şişkin" dosyalar | `Settings.php` 1095, `ProductResource.php` 1041, `DealerController.php` 594, `products/show.blade.php` 705 satır ✅ | Bakımı zor; bölünebilir (DealerController → ayrı Controller'lar/Service; Filament form'ları Schema sınıflarına). |
| B8 | Blog görüntülenme sayacı senkron | `increment('views')` (PostService) | Yüksek trafikte yazma kilidi/yarış; queue'ya alınabilir. |
| B9 | Ürün aramada `LIKE %...%` | `ProductRepository:119-124` ✅ | 5 kolonda baştan-joker → index kullanılamaz. Ürün sayısı büyürse fulltext/Scout'a geçiş. |
| B10 | Mega menü görsel URL'i her render'da | `partials/mega-menu.blade.php` (Storage::url döngüde) 🔍 | Kategori×ürün kadar çağrı; verisi cache'li ama URL üretimi değil. |

---

### 🟢 DÜŞÜK / İYİLEŞTİRME

- `mail.admin_emails` fallback'i koda gömülü (`DealerController:185, 494`) — biri `admin@`, diğeri `info@unikeyterra.com` (tutarsız). Config'de tek yerde tanımlanmalı. ✅
- API token'larda `expires_at` set edilmiyor (süresiz token) — 🔍 ajan bulgusu, `AuthController`/`ApiToken` ile teyit edilmeli.
- Kök dizinde çöp/karışıklık dosyaları: `urun.html` (269KB), `vaniurun.png` (677KB), `debug-megamenu.json`, `cookies.txt`, `surec.txt`, `temp_backup/`, `_nul`, `nul`, `wordpress-api-test.*`, `warmup.php`. ✅ Temizlenmeli (git olmadığı için dikkatli, önce taşıma).
- `TranslatableInput`'ta 3 metot benzer mantığı tekrar ediyor (DRY) — 🔍.

---

## 5. Çürütülen "Kritik" İddialar (güvenin kalanı için)

Otomatik tarama bunları "kritik" işaretledi; **birincil kaynaktan yanlış çıktılar**:

| İddia | Gerçek |
|---|---|
| `APP_DEBUG=true` (üretim) | ❌ `.env.production`'da `APP_DEBUG=false`, `APP_ENV=production`. Sadece dev `.env`'de true (normal). ✅ |
| Bayi kaydında CSRF eksik | ❌ Bayi auth rotaları varsayılan `web` grubunda → CSRF aktif. ✅ |
| Import rotaları yetkisiz | ❌ Public kullanıcı kaydı yok; `web` guard = yalnızca admin → `auth` middleware pratikte admin-only. ✅ |
| `profileUpdate`'te role mass-assignment | ❌ `$validated` `role` içermiyor (validation whitelist'liyor). ✅ |
| Şifre sıfırlamada timing attack | ❌ Token `Str::random(64)` + 1 saat expiry; pratik değil. ✅ |
| `catalogs` / `category_product` index eksik | ❌ `catalogs`'ta `status`+`language` index var; pivot'ta PK `(category_id,product_id)` + `product_id` index var. ✅ |

---

## 6. Önerilen İyileştirme Yol Haritası (tematik)

**A. Acil düzeltmeler (düşük risk):**
1. B1 — Bayi `is_active` → `status` düzeltmesi (B2B akışını geri getirir).
2. B3 — `optimize-clear-cache-2024x` rotasını kaldır/gizle.
3. Kök dizin çöp dosyalarını temizle; `.gitignore` güncelle (ileride git'e geçilirse).

**B. Güvenlik sertleştirme:**
4. B4 — `throttle:quote-request` rotaya bağla.
5. API token expiry + (uzun vade) Sanctum'a geçiş değerlendirmesi.
6. `mail.admin_emails`'i config'de tek noktaya al.

**C. Performans / ölçeklenme:**
7. B5 — `getRelatedProducts`'a `category.translations` eager-load.
8. B8 — blog view sayacını queue'ya al.
9. B9 — ürün araması için fulltext/Laravel Scout (ürün sayısı arttığında).
10. B2 — kategori aktiflik konvansiyonunu tekilleştir.

**D. Sürdürülebilirlik:**
11. B6 — kritik akışlara feature testi (teklif gönderimi, dil değişimi, ürün/kategori sayfası, bayi giriş).
12. B7 — `DealerController` ve büyük Filament form'larını parçala.

**E. SEO (mevcut iş üstüne):**
13. Hafıza notundaki **prod ön-koşulu**: www↔non-www tek host 301 (edge), canonical=hreflang host eşitliği. (Kod değil, ops.)

---

## 7. Açık Sorular (sahibine)

- B1 prod'da fark edildi mi — bayi paneli aktif kullanımda mı, yoksa henüz canlı değil mi? (Önceliklendirmeyi belirler.)
- B2 için tercih: `status` mi `is_active` mi standart olsun?
- Git'e geçiş planı var mı? (Test + güvenli refactor için kritik.)
- Order/Invoice modülü canlı mı yoksa gelecek özellik mi? (Stok takibi placeholder.)
