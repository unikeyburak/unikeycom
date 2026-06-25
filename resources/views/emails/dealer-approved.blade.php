<x-mail::message>
# Bayi Başvurunuz Onaylandı

Sayın {{ $dealer->contact_person }},

**{{ $dealer->company_name }}** için yapmış olduğunuz bayi başvurunuz onaylanmıştır.

Artık bayi panelinize giriş yaparak ürünlerimizi inceleyebilir ve teklif taleplerinde bulunabilirsiniz.

<x-mail::panel>
**Giriş Bilgileriniz:**
- **E-posta:** {{ $dealerUser->email }}
- **Geçici Şifre:** {{ $temporaryPassword }}

⚠️ **Önemli:** İlk girişinizde lütfen şifrenizi değiştirin.
</x-mail::panel>

<x-mail::button :url="$loginUrl">
Bayi Paneline Giriş Yap
</x-mail::button>

## Bayi Panelinizden Yapabilecekleriniz:

- ✓ Ürün kataloğumuzu inceleme
- ✓ Ürünler için teklif talebi oluşturma
- ✓ Teklif taleplerinizi takip etme
- ✓ Firma ve profil bilgilerinizi güncelleme

Herhangi bir sorunuz olursa bizimle iletişime geçmekten çekinmeyin.

Başarılı bir işbirliği dileriz!

Saygılarımızla,<br>
{{ config('app.name') }} Ekibi
</x-mail::message>