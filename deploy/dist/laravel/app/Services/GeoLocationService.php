<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoLocationService
{
    /**
     * İstekten ülke kodunu al (Cloudflare vb. header'ları önceliklendirir)
     */
    public function getCountryFromRequest(Request $request): ?string
    {
        $headerCandidates = [
            'CF-IPCountry',
            'X-GeoIP-Country-Code',
            'CloudFront-Viewer-Country',
            'X-Country-Code',
        ];

        foreach ($headerCandidates as $header) {
            $value = strtoupper(trim((string) $request->header($header, '')));
            if ($value !== '' && $value !== 'XX') {
                return $value;
            }
        }

        return $this->getCountryByIp($request->ip());
    }

    /**
     * IP adresinden ülke kodunu al
     */
    public function getCountryByIp(string $ip): ?string
    {
        // Localhost kontrolü
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            return 'TR'; // Localhost için varsayılan
        }

        // Cache kontrolü
        $cacheKey = 'geo_ip_' . $ip;
        $cached = Cache::get($cacheKey);
        
        if ($cached !== null) {
            return $cached !== '' ? $cached : null;
        }

        if (!config('services.geoip.enabled', true)) {
            Cache::put($cacheKey, '', (int) config('services.geoip.cache_seconds', 3600));
            return null;
        }

        // IP-API.com kullanarak ülke bilgisi al (ücretsiz)
        try {
            $timeout = (float) config('services.geoip.timeout', 1.5);
            $response = Http::timeout($timeout)->get('http://ip-api.com/json/' . $ip, [
                'fields' => 'countryCode'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $countryCode = $data['countryCode'] ?? null;
                
                // 24 saat cache'le (boşsa da işaretle)
                Cache::put($cacheKey, $countryCode ?? '', (int) config('services.geoip.cache_seconds', 86400));
                
                return $countryCode;
            }
        } catch (\Exception $e) {
            // Hata durumunda log tutabilirsiniz
        }

        Cache::put($cacheKey, '', (int) config('services.geoip.cache_seconds', 3600));
        return null;
    }

    /**
     * Ülke koduna göre dil kodunu belirle
     */
    public function getLanguageByCountry(string $countryCode): string
    {
        $countryLanguageMap = [
            // Türkçe konuşulan ülkeler
            'TR' => 'tr', // Türkiye
            'AZ' => 'tr', // Azerbaycan
            
            // İngilizce konuşulan ülkeler
            'US' => 'en', // ABD
            'GB' => 'en', // İngiltere
            'CA' => 'en', // Kanada
            'AU' => 'en', // Avustralya
            'NZ' => 'en', // Yeni Zelanda
            'IN' => 'en', // Hindistan
            'ZA' => 'en', // Güney Afrika
            'IE' => 'en', // İrlanda
            
            // İspanyolca konuşulan ülkeler
            'ES' => 'es', // İspanya
            'MX' => 'es', // Meksika
            'AR' => 'es', // Arjantin
            'CO' => 'es', // Kolombiya
            'CL' => 'es', // Şili
            'PE' => 'es', // Peru
            'VE' => 'es', // Venezuela
            'EC' => 'es', // Ekvador
            'GT' => 'es', // Guatemala
            'CU' => 'es', // Küba
            'BO' => 'es', // Bolivya
            'DO' => 'es', // Dominik Cumhuriyeti
            'HN' => 'es', // Honduras
            'PY' => 'es', // Paraguay
            'SV' => 'es', // El Salvador
            'NI' => 'es', // Nikaragua
            'CR' => 'es', // Kosta Rika
            'PA' => 'es', // Panama
            'UY' => 'es', // Uruguay
            
            // Fransızca konuşulan ülkeler
            'FR' => 'fr', // Fransa
            'BE' => 'fr', // Belçika (kısmen)
            'CH' => 'fr', // İsviçre (kısmen)
            'LU' => 'fr', // Lüksemburg
            'MC' => 'fr', // Monako
            'SN' => 'fr', // Senegal
            'CI' => 'fr', // Fildişi Sahili
            'ML' => 'fr', // Mali
            'BF' => 'fr', // Burkina Faso
            'NE' => 'fr', // Nijer
            'TG' => 'fr', // Togo
            'BJ' => 'fr', // Benin
            'MG' => 'fr', // Madagaskar
            'CM' => 'fr', // Kamerun
            'TD' => 'fr', // Çad
            'HT' => 'fr', // Haiti
            
            // Arapça konuşulan ülkeler
            'SA' => 'ar', // Suudi Arabistan
            'EG' => 'ar', // Mısır
            'AE' => 'ar', // BAE
            'IQ' => 'ar', // Irak
            'JO' => 'ar', // Ürdün
            'LB' => 'ar', // Lübnan
            'LY' => 'ar', // Libya
            'MA' => 'ar', // Fas
            'OM' => 'ar', // Umman
            'PS' => 'ar', // Filistin
            'QA' => 'ar', // Katar
            'SD' => 'ar', // Sudan
            'SY' => 'ar', // Suriye
            'TN' => 'ar', // Tunus
            'YE' => 'ar', // Yemen
            'KW' => 'ar', // Kuveyt
            'BH' => 'ar', // Bahreyn
            'DZ' => 'ar', // Cezayir
        ];

        return $countryLanguageMap[$countryCode] ?? 'en'; // Varsayılan İngilizce
    }

    /**
     * Tarayıcı dilini algıla
     */
    public function getBrowserLanguage(string $acceptLanguage): ?string
    {
        // Accept-Language header'ını parse et
        $languages = [];
        
        $langPairs = explode(',', $acceptLanguage);
        foreach ($langPairs as $pair) {
            $parts = explode(';', $pair);
            $lang = strtolower(trim($parts[0]));
            $quality = 1.0;
            
            if (isset($parts[1])) {
                preg_match('/q=([0-9.]+)/', $parts[1], $matches);
                $quality = isset($matches[1]) ? (float) $matches[1] : 1.0;
            }
            
            // Sadece ilk 2 karakteri al (tr-TR -> tr)
            $lang = substr($lang, 0, 2);
            
            $languages[$lang] = $quality;
        }
        
        // Kaliteye göre sırala
        arsort($languages);
        
        // Desteklenen diller
        $supportedLanguages = ['tr', 'en', 'es', 'fr', 'ar'];
        
        foreach ($languages as $lang => $quality) {
            if (in_array($lang, $supportedLanguages)) {
                return $lang;
            }
        }
        
        return null;
    }
}
