<x-mail::message>
# Yeni Bayi Başvurusu

Sayın Yönetici,

Yeni bir bayi başvurusu alındı. Detaylar aşağıda:

<x-mail::panel>
**Firma Bilgileri:**
- **Firma Adı:** {{ $dealer->company_name }}
- **Vergi No:** {{ $dealer->tax_number }}
- **Vergi Dairesi:** {{ $dealer->tax_office }}

**İletişim Bilgileri:**
- **Yetkili Kişi:** {{ $dealer->contact_person }}
- **E-posta:** {{ $dealer->email }}
- **Telefon:** {{ $dealer->phone }}

**Adres:**
{{ $dealer->address }}, {{ $dealer->district }}/{{ $dealer->city }}

**Başvuru Tarihi:** {{ $dealer->created_at->format('d.m.Y H:i') }}
</x-mail::panel>

<x-mail::button :url="$adminUrl">
Başvuruyu İncele
</x-mail::button>

Bu başvuruyu admin panelinden inceleyebilir ve onaylayabilirsiniz.

Saygılarımızla,<br>
{{ config('app.name') }}
</x-mail::message>