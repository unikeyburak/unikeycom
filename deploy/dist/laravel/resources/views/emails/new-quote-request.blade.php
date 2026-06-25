<x-mail::message>
# Yeni Teklif Talebi

Sayın Yönetici,

**{{ $dealer->company_name }}** firması tarafından yeni bir teklif talebi oluşturuldu.

<x-mail::panel>
**Ürün Bilgileri:**
- **Ürün:** {{ $product->name }}
- **SKU:** {{ $product->sku }}
- **Kategori:** {{ $product->category->name }}

**Teklif Detayları:**
- **Miktar:** {{ $quoteRequest->quantity }} {{ $quoteRequest->unit }}
- **Teslimat Şehri:** {{ $quoteRequest->delivery_city ?? 'Belirtilmemiş' }}
- **Teslimat Tarihi:** {{ $quoteRequest->delivery_date ? $quoteRequest->delivery_date->format('d.m.Y') : 'Belirtilmemiş' }}
- **Kullanım Amacı:** {{ $quoteRequest->usage_purpose ?? 'Belirtilmemiş' }}
- **Ödeme Yöntemi:** {{ $quoteRequest->payment_method ?? 'Belirtilmemiş' }}

@if($quoteRequest->notes)
**Ek Notlar:**
{{ $quoteRequest->notes }}
@endif

**Talep Tarihi:** {{ $quoteRequest->created_at->format('d.m.Y H:i') }}
</x-mail::panel>

<x-mail::button :url="$adminUrl">
Teklifi İncele
</x-mail::button>

Bu teklif talebini admin panelinden inceleyebilir ve işleme alabilirsiniz.

Saygılarımızla,<br>
{{ config('app.name') }}
</x-mail::message>