# Güvenlik Dokümantasyonu

Bu dokuman, projede uygulanan güvenlik önlemlerini ve en iyi uygulamaları açıklar.

## 1. Güvenlik Başlıkları (Security Headers)

`app/Http/Middleware/SecurityHeaders.php` middleware'i ile aşağıdaki güvenlik başlıkları uygulanmaktadır:

### Content Security Policy (CSP)
- Script kaynaklarını güvenilir domainlerle sınırlar
- Inline scriptlere nonce ile izin verir
- XSS saldırılarına karşı koruma sağlar

### Diğer Güvenlik Başlıkları
- `X-Content-Type-Options: nosniff` - MIME type sniffing'i engeller
- `X-Frame-Options: SAMEORIGIN` - Clickjacking saldırılarını önler
- `X-XSS-Protection: 1; mode=block` - XSS filtresini aktifleştirir
- `Referrer-Policy: strict-origin-when-cross-origin` - Referrer bilgisini kontrol eder
- `Permissions-Policy` - Tarayıcı özelliklerini sınırlar
- `Strict-Transport-Security` - HTTPS üzerinde (max-age=31536000)

## 2. Rate Limiting

`app/Providers/AppServiceProvider.php` dosyasında tanımlı rate limiter'lar:

- **API**: Dakikada 60 istek (misafir), 120 istek (giriş yapmış)
- **Login**: Dakikada 5 deneme
- **İletişim Formu**: Saatte 5 gönderim
- **Bayi Kayıt**: Günde 3 başvuru
- **Teklif Talebi**: Saatte 10 talep
- **Şifre Sıfırlama**: Saatte 3 deneme
- **Dosya Yükleme**: Dakikada 10 yükleme

## 3. CSRF Koruması

Laravel'in yerleşik CSRF koruması tüm POST, PUT, DELETE isteklerinde aktiftir. Tüm formlarda `@csrf` direktifi kullanılmaktadır.

## 4. XSS Koruması

### Blade Template Engine
- Varsayılan olarak tüm çıktılar `{{ }}` ile escape edilir
- Sadece güvenilir içerik için `{!! !!}` kullanılır (admin panelden gelen zengin metin)

### Input Sanitization
`app/Http/Middleware/SanitizeInput.php` middleware'i ile:
- Tehlikeli HTML tag'leri kaldırılır
- JavaScript injection önlenir
- Null byte ve kontrol karakterleri temizlenir

## 5. SQL Injection Koruması

- Eloquent ORM ve Query Builder kullanılarak parametreli sorgular
- Raw SQL sorguları kullanılmamaktadır
- Tüm kullanıcı girdileri validation'dan geçirilir

## 6. API Güvenliği

### Token Yönetimi
- SHA-256 ile hash'lenmiş tokenlar
- Token son kullanım tarihi kontrolü
- Token iptal etme özelliği
- Her token kullanımında last_used_at güncellenir

### API Authentication Middleware
`app/Http/Middleware/ApiAuthentication.php`:
- Bearer token doğrulaması
- Bayi ve kullanıcı durumu kontrolü
- API kullanım loglaması

## 7. Dosya Yükleme Güvenliği

- Dosya tipi ve boyut kontrolleri
- Güvenli dosya isimlendirme
- Public dizin dışında storage
- MIME type doğrulaması

## 8. Session Güvenliği

- Secure cookie flag'i (HTTPS üzerinde)
- HttpOnly cookie'ler
- Same-site cookie politikası
- Session timeout ayarları

## 9. Şifre Güvenliği

- Bcrypt hashing algoritması
- Minimum şifre gereksinimleri
- Şifre sıfırlama token'ları
- Geçici şifre politikası

## 10. Hata Yönetimi

- Production'da debug modu kapalı
- Özel hata sayfaları
- Hassas bilgilerin loglanmaması
- Structured error responses

## 11. Input Validation

Tüm controller'larda Laravel validation kuralları:
- Required field kontrolleri
- Tip kontrolleri (string, integer, email, vb.)
- Maksimum uzunluk kontrolleri
- Unique kontrolleri
- Format kontrolleri (regex)

## 12. Security.txt

`public/.well-known/security.txt` dosyası güvenlik açığı bildirimleri için iletişim bilgilerini içerir.

## Güvenlik Kontrol Listesi

- [x] Security Headers Middleware
- [x] Rate Limiting
- [x] CSRF Protection
- [x] XSS Protection
- [x] SQL Injection Protection
- [x] API Token Security
- [x] Input Sanitization
- [x] File Upload Security
- [x] Session Security
- [x] Password Security
- [x] Error Handling
- [x] Input Validation
- [x] Security.txt

## Güvenlik Açığı Bildirimi

Güvenlik açıklarını `security@unikeyterra.com` adresine bildirin. Güvenlik açıklarını kamusal olarak paylaşmadan önce bize bildirmenizi rica ederiz.