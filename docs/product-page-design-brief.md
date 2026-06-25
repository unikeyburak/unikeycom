# Ürün Detay Sayfası — Tasarım Brief'i (claude.ai/design)

> Bu dosya **olduğu gibi claude.ai/design'a yapıştırılmak** için hazırlanmıştır.
> Amaç: aşağıdaki design system token'ları ve component yapısı **üzerine** çalışan,
> sıfırdan yorumlanmamış bir ürün detay sayfası tasarımı üretmek.

---

## 1. Bağlam

- **Site:** Keysol Agro — B2B tarım / bitki besleme ürünleri (gübre, biyostimülant). Çok dilli (TR/EN/FR), fiyat yok (teklif usulü).
- **Teknoloji:** Laravel 12 + Blade + **Tailwind CSS v4** (utility-first) + **Alpine.js 3**. Bootstrap YOK.
- **Referans düzen:** Van Iperen ürün sayfası (`/products/...`). Aynı bölüm akışı korunacak; renk/his **yeşil-cyan karma** olacak, birebir Van Iperen yeşili değil.
- **Hedef:** Mevcut sayfa düzeni doğru ama CSS'i bozuk (eski `product-detail.css` içinde 301 `!important`). Yeni tasarım **saf Tailwind utility** ile, aşağıdaki token'larla üretilecek; sayfaya özel CSS minimumda tutulacak.

## 2. Design System Token'ları (ZORUNLU — bunları kullan)

Tailwind v4 `@theme` ile tanımlı. Üretilen utility'leri kullan: `bg-brand-500`, `text-leaf-600`, `border-brand-900`, `ring-leaf-400` vb. Ham hex KULLANMA.

**Marka (cyan/teal) — ana yapısal renk**
| Token | Hex | Kullanım |
|---|---|---|
| `brand-50` | `#ecfeff` | açık zemin |
| `brand-100` | `#cffafe` | rozet/etiket zemini |
| `brand-500` | `#0891b2` | **birincil** (CTA, linkler, vurgu) |
| `brand-600` | `#0e7490` | hover |
| `brand-700` | `#155e75` | koyu vurgu |
| `brand-900` | `#083344` | en koyu teal (başlık şeritleri, footer) |

**Aksan (tarım yeşili) — ikincil / doğa vurgusu**
| Token | Hex | Kullanım |
|---|---|---|
| `leaf-50` | `#f3faec` | yeşil açık zemin |
| `leaf-100` | `#e3f3d1` | yeşil rozet zemini |
| `leaf-400` | `#84cc16` | canlı yaprak (ikon/işaret) |
| `leaf-500` | `#5fa024` | aksan ana (madde işaretleri, check) |
| `leaf-600` | `#4d8a1f` | **koyu yeşil — sekme şeridi / aktif sekme** |

**Nötr metin:** `ink` = `#1f2937` (ana metin), `ink-soft` = `#64748b` (ikincil metin).

> **Karma kuralı:** Sayfa iskeleti/CTA **cyan (brand)**; doğa/agronomi vurguları, madde işaretleri, sekme aktif durumu **yeşil (leaf)**. Üst başlık şeridi koyu teal→yeşil geçişli bir gradient olabilir (`from-brand-900 to-leaf-700`).

## 3. Tipografi & Spacing

- **Font:** Inter (`--font-sans`). Başlıklar 700-800, gövde 400-500.
- H1 ürün başlığı: `clamp(1.875rem, 4vw, 3rem)`, koyu/beyaz (şerit zemine göre).
- Gövde metni: 1rem / line-height 1.6, `text-ink-soft`.
- Bölüm dikey boşluğu: `py-12 lg:py-16`. İçerik genişliği: `max-w-6xl mx-auto px-4`.
- Köşe yuvarlaklığı: kartlar `rounded-2xl`, butonlar `rounded-xl`, rozetler `rounded-full`.

## 4. Mevcut Component'ler (yeniden kullan — yeniden icat etme)

- **`<x-responsive-image>`** — `src`, `alt`, `width`, `height`, `loading`, `sizes` alır; srcset + CLS-güvenli. **Ürün görseli bununla** (ham `<img>` değil).
- **Alpine sekme deseni** — kök elemanda `x-data="{ tab: 'characteristics' }"`, sekme butonu `@click="tab='dosing'"` + `:class="{ 'active': tab==='dosing' }"`, panel `x-show="tab==='dosing'" x-cloak`. Bu deseni KORU.
- **Tailwind kart/buton deseni** (zaten projede mevcut): `bg-white rounded-2xl border border-gray-100 hover:shadow-lg transition-all`.
- **RTL desteği:** Arapça için `dir="rtl"`. Yön-bağımlı boşluklarda mantıksal utility (`ms-`, `me-`, `ps-`, `pe-`) tercih et; `pl-/pr-` kullanma.

## 5. Sayfa Düzeni — Bölüm Bölüm (gerçek veri alanlarıyla)

> Tasarım **lorem ipsum yerine** aşağıdaki gerçek alan adlarıyla kurgulanmalı. Her bölüm,
> ilgili veri yoksa render edilmez (koşullu). Alanlar `products/show.blade.php` veri modelinden.

### Bölüm 1 — Ürün Başlık Şeridi
- Üstte küçük **kategori etiketi** (`$categoryName`) — yeşil rozet (`bg-leaf-100 text-leaf-700`).
- **H1 ürün adı** (`$product->name`) + ince **alt-başlık** (`$product->subtitle`/`$product->formula`/`$product->sku`).
- Zemin: koyu teal→yeşil gradient şerit veya beyaz (her ikisinin mockup'ı yapılabilir).

### Bölüm 2 — Ürün Tanıtım (2 kolon: sol görsel / sağ içerik)
**Sol kolon (≈ %40):**
- Ürün görseli (beyaz zeminde, contain) — `<x-responsive-image>`.
- Altında üç ikon-set bloğu (her biri başlık + ikon listesi; veri varsa):
  - **Uygulama** (`$appTypes`): fertigation/yapraktan/topraktan ikonları.
  - **Agronomik Hedef** (`$cropApproaches`).
  - **Sertifikalar** (`$certifications`): CE / organik logoları (logo yoksa metin rozet).
**Sağ kolon (≈ %60):**
- **Kısa açıklama** (`$product->short_description`).
- **Öne çıkanlar** listesi (`$highlights`) — yeşil check (`leaf-500`) madde işaretli.
- **Ambalaj** boyutları (`$packages`) — küçük pill rozetler.
- **Renk seçenekleri** (`$productColors`) — renk swatch + etiket.
- **CTA:** "Teklif Al / İletişime Geç" — birincil cyan buton (`bg-brand-500 hover:bg-brand-600`).

### Bölüm 3 — Sekmeli Detay Alanı (yeşil şerit)
Sekme navigasyonu yeşil zeminli (`bg-leaf-600`), aktif sekme beyaz/alt çizgi. Sekmeler (veri varsa):
- **Özellikler** (`$highlights` + `$product->features_text`) — 2 kolon liste.
- **Dozaj** (`$dosageItems`) — tablo: Ürün / Sulama / Yapraktan / Topraktan / Uygulama Dönemi.
- **Teknik Bilgiler** (`$techTableRows`) — anahtar/değer tablosu.
- **Uygulama Bilgisi** (`$appInfo`) — başlık+açıklama kartları (2 kolon).
- **İndirmeler** (`$product->brochure_pdf`, `registration_certificate`, `label_certificate`) — PDF ikonlu liste.
- **Uyarı / Karışım** (`$warningInfo`, `$mixingInfo`) — uyarı kartları (sarı/kırmızı ince vurgu).
- **Mobilde:** sekmeler akordeon olur (tıkla-aç/kapa).

### Bölüm 4 — İlgili Ürünler
- 2/3/4 kolon responsive grid; her kart: görsel + kategori etiketi + ürün adı; hover'da yükselme + cyan başlık.

### Bölüm 5 — CTA Bandı
- Koyu teal→cyan gradient (`from-brand-900 to-brand-600`); başlık + açıklama + "Teklif Al" beyaz buton + telefon butonu.

## 6. Erişilebilirlik

- Dekoratif ikon/SVG'lere `aria-hidden="true"`; anlamlı olanlara `aria-label`/`sr-only` etiket.
- Sayfada **tek H1** (ürün adı). Sekme başlıkları buton; panel `role`/`aria-controls` ile bağlı.
- Renk kontrastı WCAG AA (yeşil zeminde beyaz metin kontrastını doğrula; `leaf-600` üzerine beyaz uygundur).

## 7. Çıktı Formatı (claude.ai/design'a talimat)

1. **Tercih edilen:** Tek dosyalık, çalışan **HTML + Tailwind v4 utility** (yukarıdaki token isimleriyle: `bg-brand-500`, `text-leaf-600` …). Sekmeler için Alpine.js `x-data`/`x-show` deseni.
2. Alternatif: yüksek çözünürlüklü **görsel mockup** (desktop + mobil).
3. Custom CSS'i minimumda tut; kaçınılmazsa kısa bir `@layer components` bloğu olarak ver.
4. Bölümleri yukarıdaki sıra ve gerçek alan adlarıyla etiketle (entegrasyon kolay olsun diye).

---

### Entegrasyon notu (geliştirici için)
Çıktı geldiğinde `resources/views/products/show.blade.php` markup'ı bu tasarıma göre yeniden yazılacak; `@php` veri-hazırlama bloğu ve Alpine sekme mantığı korunacak. `product-detail.css` ve `vite.config.js`'teki ilgili entry kaldırılacak.
