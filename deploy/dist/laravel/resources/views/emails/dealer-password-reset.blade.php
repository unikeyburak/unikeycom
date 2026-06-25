<x-mail::message>
# Şifre Sıfırlama Talebi

Sayın {{ $dealerUser->name }},

Hesabınız için şifre sıfırlama talebinde bulundunuz. Şifrenizi sıfırlamak için aşağıdaki butona tıklayın:

<x-mail::button :url="$resetUrl">
Şifremi Sıfırla
</x-mail::button>

Bu link **60 dakika** içinde geçerliliğini yitirecektir.

Eğer bu talebi siz yapmadıysanız, bu e-postayı görmezden gelebilirsiniz.

---

**Not:** Butona tıklayamıyorsanız, aşağıdaki linki tarayıcınıza kopyalayıp yapıştırın:  
{{ $resetUrl }}

Saygılarımızla,<br>
{{ config('app.name') }}
</x-mail::message>