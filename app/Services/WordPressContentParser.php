<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * WordPress/WooCommerce HTML içeriğini parse ederek
 * Laravel ürün alanlarına doğru şekilde eşler.
 *
 * WooCommerce description HTML'inde üç bölüm olabilir:
 * 1) DESCRIPTION  → short_description / long_description
 * 2) CONTENT      → technical_info (bileşim/garantili içerik tablosu)
 * 3) DOSAGES      → dosage_items (dozaj uygulama tablosu)
 */
class WordPressContentParser
{
    /**
     * Bileşim/içerik bölümü anahtar kelimeler (TR + EN, küçük harf)
     */
    protected array $compositionKeywords = [
        // Türkçe
        'garantili bileşim', 'garantili içerik', 'bileşim', 'içerik',
        'bileşenler', 'içerik analizi', 'teknik bilgi', 'teknik özellikler',
        'analiz', 'içerik tablosu', 'bileşim tablosu', 'formül',
        'ham madde', 'hammadde', 'besin içeriği', 'besin analizi',
        // İngilizce
        'guaranteed composition', 'guaranteed analysis', 'composition',
        'content', 'analysis', 'technical info', 'technical information',
        'ingredients', 'components', 'guaranteed', 'nutrient content',
        'nutrient analysis', 'formulation', 'formula', 'specification',
    ];

    /**
     * Dozaj bölümü anahtar kelimeler (TR + EN, küçük harf)
     */
    protected array $dosageKeywords = [
        // Türkçe
        'dozaj', 'doz', 'uygulama dozu', 'uygulama dozları',
        'kullanım dozu', 'uygulama miktarı', 'uygulama tablosu',
        'kullanım tablosu', 'uygulama rehberi', 'kullanım rehberi',
        'tavsiye edilen doz', 'öneri', 'kullanım önerileri',
        // İngilizce
        'dosage', 'dose', 'doses', 'dosages', 'application rate',
        'application rates', 'recommended dose', 'recommended dosage',
        'application table', 'usage table', 'rates', 'dilution',
    ];

    /**
     * Dozaj sütun başlığı → dosage_items alan eşleme (küçük harf)
     */
    protected array $dosageColumnMap = [
        // crop - bitki/ürün sütunu
        'bitki'                => 'crop',
        'ürün'                 => 'crop',
        'bitki/ürün'           => 'crop',
        'bitki adı'            => 'crop',
        'kültür'               => 'crop',
        'plant'                => 'crop',
        'crop'                 => 'crop',
        'crop/product'         => 'crop',
        'product'              => 'crop',
        'culture'              => 'crop',

        // sulama_dosage - damlama/sulama
        'sulama'               => 'sulama_dosage',
        'sulama dozu'          => 'sulama_dosage',
        'damlama'              => 'sulama_dosage',
        'damlama sulama'       => 'sulama_dosage',
        'fertigation'          => 'sulama_dosage',
        'drip irrigation'      => 'sulama_dosage',
        'drip'                 => 'sulama_dosage',
        'irrigation'           => 'sulama_dosage',
        'soil drenching'       => 'sulama_dosage',
        'sulama sistemi'       => 'sulama_dosage',

        // yapraktan_dosage - foliar
        'yapraktan'            => 'yapraktan_dosage',
        'yapraktan dozu'       => 'yapraktan_dosage',
        'yapraktan uygulama'   => 'yapraktan_dosage',
        'foliar'               => 'yapraktan_dosage',
        'foliar application'   => 'yapraktan_dosage',
        'foliar spray'         => 'yapraktan_dosage',
        'spray'                => 'yapraktan_dosage',

        // topraktan_dosage - soil
        'topraktan'            => 'topraktan_dosage',
        'topraktan dozu'       => 'topraktan_dosage',
        'topraktan uygulama'   => 'topraktan_dosage',
        'soil'                 => 'topraktan_dosage',
        'soil application'     => 'topraktan_dosage',
        'granule'              => 'topraktan_dosage',

        // application_period - uygulama zamanı/dönemi
        'uygulama zamanı'      => 'application_period',
        'uygulama zamani'      => 'application_period',
        'uygulama dönemi'      => 'application_period',
        'uygulama donemi'      => 'application_period',
        'dönem'                => 'application_period',
        'zaman'                => 'application_period',
        'aralık'               => 'application_period',
        'application period'   => 'application_period',
        'application timing'   => 'application_period',
        'timing'               => 'application_period',
        'period'               => 'application_period',
        'interval'             => 'application_period',
        'frequency'            => 'application_period',

        // notes - not/açıklama
        'not'                  => 'notes',
        'notlar'               => 'notes',
        'açıklama'             => 'notes',
        'notes'                => 'notes',
        'remarks'              => 'notes',
        'remark'               => 'notes',
        'comment'              => 'notes',

        // Genel doz sütunları (eşleşme yoksa sulama_dosage ilk boş dose alanına gider)
        'plants'               => 'crop',   // Elementor: "Plants" sütun başlığı
        'application rate'     => 'sulama_dosage',
        'dose (l/da)'          => 'sulama_dosage',
        'dose (kg/da)'         => 'sulama_dosage',
        'dose kg/da'           => 'sulama_dosage',
        'dose kg / decare'     => 'sulama_dosage',
        'usage dose'           => 'sulama_dosage',
        'recommended dose'     => 'sulama_dosage',
        'rate (l/da)'          => 'sulama_dosage',
        'rate (kg/da)'         => 'sulama_dosage',
    ];

    // ─────────────────────────────────────────────────────────────────────
    // ANA PARSE METODU
    // ─────────────────────────────────────────────────────────────────────

    /**
     * WordPress ürün verilerini parse ederek Laravel alanlarına eşler.
     *
     * @param string $wpDescription   WP/WooCommerce 'description' alanı (HTML)
     * @param string $wpShortDescription WP 'short_description' (HTML)
     * @return array {
     *   short_description: string,
     *   long_description: string,
     *   technical_info: array|null,
     *   dosage_items: array|null,
     *   dosage_info: string|null,
     *   application_info: array|null,
     * }
     */
    public function parse(string $wpDescription, string $wpShortDescription = ''): array
    {
        $result = [
            'short_description' => '',
            'long_description'  => '',
            'technical_info'    => null,
            'dosage_items'      => null,
            'dosage_info'       => null,
            'application_info'  => null,
        ];

        // short_description işle — düz metin olmalı, HTML tag'ları görünmemeli
        $shortDesc = trim(strip_tags($wpShortDescription));
        // WP excerpt bazen Elementor tab başlıklarını içeriyor: "Description Content Dosage ..."
        // Bu kalıpları temizle
        $shortDesc = preg_replace('/^(Description|Content|Dosage[s]?|DESCRIPTION|CONTENT|DOSAGE[S]?)\s+/u', '', $shortDesc);
        if (!empty($shortDesc)) {
            $result['short_description'] = $shortDesc;
        }

        $html = trim($wpDescription);
        if (empty($html)) {
            return $result;
        }

        // ─── ELEMENTOR TABS TESPİTİ ──────────────────────────────────────
        // keysolagro.com gibi Elementor kullanan sitelerde içerik
        // h1-h4 heading yerine div.elementor-tab-content yapısındadır.
        if ($this->hasElementorTabs($html)) {
            $dom = $this->loadHtml($html);
            if ($dom) {
                $xpath  = new \DOMXPath($dom);
                $parsed = $this->parseElementorTabs($dom, $xpath);
                // Elementor DESCRIPTION tab'ından short_description geldiyse kullan,
                // yoksa WP excerpt'ten gelen temizlenmiş metni kullan
                if (empty($parsed['short_description'])) {
                    $parsed['short_description'] = $result['short_description'];
                }
                // Hâlâ boşsa long_description'dan türet
                if (empty($parsed['short_description']) && !empty($parsed['long_description'])) {
                    $parsed['short_description'] = Str::limit(strip_tags($parsed['long_description']), 300);
                }
                return $parsed;
            }
        }
        // ─────────────────────────────────────────────────────────────────

        // DOMDocument ile parse et (Elementor yoksa)
        $dom = $this->loadHtml($html);
        if (!$dom) {
            $result['long_description'] = $html;
            return $result;
        }

        $xpath   = new \DOMXPath($dom);
        $wrapper = $dom->getElementById('__wp_parse_root__');
        if (!$wrapper) {
            $result['long_description'] = $html;
            return $result;
        }

        // İçeriği başlık (h1-h4) bazlı bölümlere ayır
        $sections = $this->splitIntoSections($wrapper);

        if (empty($sections)) {
            // Başlık yoksa: tüm tabloları tara, metin long_description
            $result = $this->parseFlatContent($wrapper, $xpath, $result);
            return $result;
        }

        $descriptionParts = [];

        foreach ($sections as $section) {
            $headingLower = mb_strtolower(trim($section['heading'] ?? ''), 'UTF-8');

            if ($headingLower !== '' && $this->matchesKeywords($headingLower, $this->compositionKeywords)) {
                // ─── CONTENT / Bileşim bölümü ───────────────────────────
                $parsed = $this->parseCompositionFromSection($section);
                if ($parsed) {
                    $result['technical_info'] = ['content' => $parsed];
                } else {
                    // Tablo yoksa metni long_description'a ekle
                    $descriptionParts[] = $this->sectionToHtml($section, true);
                }
            } elseif ($headingLower !== '' && $this->matchesKeywords($headingLower, $this->dosageKeywords)) {
                // ─── DOSAGES / Dozaj bölümü ─────────────────────────────
                $parsedItems = $this->parseDosageFromSection($section);
                if (!empty($parsedItems)) {
                    $result['dosage_items'] = $parsedItems;
                } else {
                    // Yapısal parse başarısız → ham HTML olarak sakla
                    $rawHtml = $this->sectionToHtml($section, false);
                    if (!empty(trim(strip_tags($rawHtml)))) {
                        $result['dosage_info'] = $rawHtml;
                    }
                }
            } else {
                // ─── DESCRIPTION / Genel içerik ─────────────────────────
                $part = $this->sectionToHtml($section, true);
                if (!empty(trim(strip_tags($part)))) {
                    $descriptionParts[] = $part;
                }
            }
        }

        $result['long_description'] = implode("\n", $descriptionParts);

        // short_description boşsa long_description'dan türet
        if (empty($result['short_description']) && !empty($result['long_description'])) {
            $result['short_description'] = Str::limit(
                strip_tags($result['long_description']),
                300
            );
        }

        return $result;
    }

    // ─────────────────────────────────────────────────────────────────────
    // ELEMENTOR TABS PARSER
    // ─────────────────────────────────────────────────────────────────────

    /**
     * HTML içeriğinde Elementor Tabs widget var mı?
     */
    protected function hasElementorTabs(string $html): bool
    {
        return str_contains($html, 'elementor-tab-content');
    }

    /**
     * Elementor Tabs widget yapısını parse eder.
     *
     * Keysolagro.com gibi siteler Elementor kullanır:
     * <div class="elementor-tab-title elementor-tab-desktop-title" data-tab="1">DESCRIPTION</div>
     * <div class="elementor-tab-content" data-tab="1" role="tabpanel">...</div>
     * <div class="elementor-tab-title elementor-tab-desktop-title" data-tab="2">CONTENT</div>
     * <div class="elementor-tab-content" data-tab="2" role="tabpanel">...</div>
     * <div class="elementor-tab-title elementor-tab-desktop-title" data-tab="3">DOSAGES</div>
     * <div class="elementor-tab-content" data-tab="3" role="tabpanel">...</div>
     *
     * Eşleme:
     * DESCRIPTION → long_description
     * CONTENT     → technical_info (bileşim tablosu)
     * DOSAGES     → dosage_items (dozaj tablosu)
     */
    protected function parseElementorTabs(\DOMDocument $dom, \DOMXPath $xpath): array
    {
        $result = [
            'short_description' => '',
            'long_description'  => '',
            'technical_info'    => null,
            'dosage_items'      => null,
            'dosage_info'       => null,
            'application_info'  => null,
        ];

        // Tab başlıklarını topla: data-tab => 'DESCRIPTION' | 'CONTENT' | 'DOSAGES' | ...
        // Sadece desktop title'ları al (mobile olanlar tekrar eder)
        $tabTitles = [];
        $titleNodes = $xpath->query('//*[contains(@class,"elementor-tab-desktop-title")]');
        if ($titleNodes->length === 0) {
            // Fallback: mobile olmayan tab title divleri
            $titleNodes = $xpath->query('//*[contains(@class,"elementor-tab-title") and not(contains(@class,"mobile"))]');
        }
        foreach ($titleNodes as $node) {
            $dataTab = $node->getAttribute('data-tab');
            if ($dataTab !== '') {
                $tabTitles[$dataTab] = strtoupper(trim($node->textContent));
            }
        }

        // Tab içeriklerini bul ve işle
        // role="tabpanel" olan içerikler (Elementor standart yapısı)
        $contentNodes = $xpath->query('//*[@role="tabpanel" and contains(@class,"elementor-tab-content")]');
        if ($contentNodes->length === 0) {
            // Fallback: class'a göre bul
            $contentNodes = $xpath->query('//*[contains(@class,"elementor-tab-content")]');
        }

        foreach ($contentNodes as $contentNode) {
            $dataTab   = $contentNode->getAttribute('data-tab');
            $tabTitle  = strtoupper(trim($tabTitles[$dataTab] ?? $dataTab));
            $innerHtml = $this->innerHtml($contentNode);

            if (empty(trim(strip_tags($innerHtml)))) {
                continue;
            }

            // Tab tipini esnek şekilde belirle
            // Siteden siteye "DESCRIPTION"/"Description"/"DESC", "DOSAGES"/"Dosage"/"DOSES" vb. değişiyor
            $tabType = $this->classifyElementorTab($tabTitle);

            switch ($tabType) {
                case 'description':
                    // Tam içeriği long_description'a al
                    $result['long_description'] = $this->cleanHtml($innerHtml);
                    // WP excerpt'teki Elementor tab başlıklarını atlayıp buradan türet
                    $result['short_description'] = Str::limit(strip_tags($innerHtml), 300);
                    break;

                case 'content':
                    // Bileşim tablosunu ara → technical_info
                    $tables = $contentNode->getElementsByTagName('table');
                    if ($tables->length > 0) {
                        $rows = $this->parseCompositionTable($tables->item(0));
                        if (!empty($rows)) {
                            $result['technical_info'] = ['content' => $rows];
                            break;
                        }
                    }
                    // Tablo yoksa raw HTML olarak sakla
                    $result['technical_info'] = ['content' => [], 'raw' => $this->cleanHtml($innerHtml)];
                    break;

                case 'dosage':
                    // Dozaj tablosunu ara → dosage_items
                    $tables = $contentNode->getElementsByTagName('table');
                    if ($tables->length > 0) {
                        $rows = $this->parseDosageTable($tables->item(0));
                        if (!empty($rows)) {
                            $result['dosage_items'] = $rows;
                            break;
                        }
                    }
                    // Yapısal parse başarısız → HTML olarak sakla
                    $result['dosage_info'] = $this->cleanHtml($innerHtml);
                    break;

                default:
                    // Bilinmeyen tab (APPLICATION, ABOUT, vb.) → description'a ekle
                    $clean = $this->cleanHtml($innerHtml);
                    if (!empty(trim(strip_tags($clean)))) {
                        $result['long_description'] .= "\n" . $clean;
                    }
                    break;
            }
        }

        return $result;
    }

    /**
     * Elementor tab başlığını standart tipe dönüştürür.
     * Siteden siteye değişen isimleri normalize eder:
     *   "DESCRIPTION" / "Description" / "Açıklama" / "About"  → 'description'
     *   "CONTENT" / "Content" / "Composition" / "Analysis"     → 'content'
     *   "DOSAGES" / "Dosage" / "Dose" / "Application" / "Rate" → 'dosage'
     *
     * @param  string $title  strtoupper() uygulanmış tab başlığı
     * @return string  'description' | 'content' | 'dosage' | 'unknown'
     */
    protected function classifyElementorTab(string $title): string
    {
        // Description grubu
        $descKeywords = [
            'DESCRIPTION', 'DESC', 'ABOUT', 'OVERVIEW', 'DETAIL', 'DETAILS',
            'AÇIKLAMA', 'TANIM', 'GENEL', 'HAKKINDA',
        ];
        // Content / Composition grubu (bileşim tablosu)
        $contentKeywords = [
            'CONTENT', 'CONTENTS', 'COMPOSITION', 'COMPONENT', 'COMPONENTS',
            'ANALYSIS', 'GUARANTEED', 'FORMULA', 'FORMULATION', 'SPECIFICATION',
            'BİLEŞİM', 'İÇERİK', 'ANALİZ', 'TEKNIK',
        ];
        // Dosage grubu
        $dosageKeywords = [
            'DOSAGE', 'DOSAGES', 'DOSE', 'DOSES', 'DOSIS',
            'APPLICATION', 'APPLICATIONS', 'RATES', 'RATE',
            'USAGE', 'HOW TO USE', 'INSTRUCTIONS',
            'DOZAJ', 'DOZ', 'UYGULAMA',
        ];

        foreach ($descKeywords as $kw) {
            if (str_contains($title, $kw)) return 'description';
        }
        foreach ($contentKeywords as $kw) {
            if (str_contains($title, $kw)) return 'content';
        }
        foreach ($dosageKeywords as $kw) {
            if (str_contains($title, $kw)) return 'dosage';
        }

        return 'unknown';
    }

    // ─────────────────────────────────────────────────────────────────────
    // BÖLÜM AYIRMA
    // ─────────────────────────────────────────────────────────────────────

    /**
     * HTML'i h1-h4 başlıklarına göre bölümlere ayırır.
     * Her bölüm: ['heading' => '...', 'nodes' => [...DOMNode]]
     */
    protected function splitIntoSections(\DOMElement $wrapper): array
    {
        $sections   = [];
        $current    = ['heading' => '', 'nodes' => []];
        $headingTags = ['h1', 'h2', 'h3', 'h4'];

        foreach ($wrapper->childNodes as $node) {
            if ($node->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            $tag = strtolower($node->nodeName);

            if (in_array($tag, $headingTags)) {
                // Mevcut bölümü kaydet (içeriği varsa)
                if (!empty($current['nodes']) || $current['heading'] !== '') {
                    $sections[] = $current;
                }
                $current = [
                    'heading' => $this->nodeToText($node),
                    'nodes'   => [],
                ];
            } else {
                $current['nodes'][] = $node;
            }
        }

        // Son bölümü ekle
        if (!empty($current['nodes']) || $current['heading'] !== '') {
            $sections[] = $current;
        }

        return $sections;
    }

    // ─────────────────────────────────────────────────────────────────────
    // BAŞLIKSIZ (FLAT) İÇERİK PARSE
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Başlık olmayan düz HTML'den tabloları çıkartır.
     * Birden fazla tablo varsa: ilk → bileşim, ikinci → dozaj.
     */
    protected function parseFlatContent(\DOMElement $wrapper, \DOMXPath $xpath, array $result): array
    {
        $tables = $xpath->query('.//table', $wrapper);
        $tableCount = $tables->length;

        if ($tableCount === 0) {
            // Tablo yok → tüm HTML long_description
            $result['long_description'] = $this->innerHtml($wrapper);
            return $result;
        }

        $processedTables = [];
        $textParts       = [];

        // Tüm tabloları sınıflandır
        foreach ($tables as $table) {
            $headers = $this->extractTableHeaders($table);
            $headerStr = mb_strtolower(implode(' ', $headers), 'UTF-8');

            $isDosage      = $this->matchesKeywords($headerStr, array_keys($this->dosageColumnMap));
            $isComposition = !$isDosage && $this->looksLikeCompositionTable($table, $headers);

            $processedTables[] = [
                'table'       => $table,
                'isDosage'    => $isDosage,
                'isComp'      => $isComposition,
            ];
        }

        foreach ($processedTables as $item) {
            if ($item['isDosage'] && $result['dosage_items'] === null) {
                $rows = $this->parseDosageTable($item['table']);
                if (!empty($rows)) {
                    $result['dosage_items'] = $rows;
                    continue;
                }
            }

            if ($item['isComp'] && $result['technical_info'] === null) {
                $rows = $this->parseCompositionTable($item['table']);
                if (!empty($rows)) {
                    $result['technical_info'] = ['content' => $rows];
                    continue;
                }
            }

            // Sınıflandırılamayan → long_description'a al
            $textParts[] = $this->outerHtml($item['table']);
        }

        // Tablolar dışındaki metin
        $nonTableHtml = $this->extractNonTableContent($wrapper, $xpath);
        if (!empty(trim(strip_tags($nonTableHtml)))) {
            array_unshift($textParts, $nonTableHtml);
        }

        $result['long_description'] = implode("\n", array_filter($textParts));

        return $result;
    }

    // ─────────────────────────────────────────────────────────────────────
    // BİLEŞİM TABLOSU PARSE
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Section içindeki bileşim tablosunu parse eder.
     * Döndürür: [['name' => 'Organik Madde', 'percentage' => '25'], ...]
     * ya da [['name' => 'pH', 'percentage' => '8.5-10.5'], ...]
     */
    protected function parseCompositionFromSection(array $section): ?array
    {
        foreach ($section['nodes'] as $node) {
            if ($node->nodeType !== XML_ELEMENT_NODE) continue;

            $tag = strtolower($node->nodeName);

            // Doğrudan tablo
            if ($tag === 'table') {
                $rows = $this->parseCompositionTable($node);
                if (!empty($rows)) return $rows;
            }

            // figure > table (Gutenberg)
            if (in_array($tag, ['figure', 'div'])) {
                $tables = $node->getElementsByTagName('table');
                foreach ($tables as $tbl) {
                    $rows = $this->parseCompositionTable($tbl);
                    if (!empty($rows)) return $rows;
                }
            }
        }

        return null;
    }

    /**
     * Bir <table> DOM elemanından bileşim satırlarını çıkartır.
     * Döndürür: [['name' => string, 'percentage' => string], ...]
     */
    protected function parseCompositionTable(\DOMElement $table): array
    {
        $rows   = [];
        $allTrs = $table->getElementsByTagName('tr');

        foreach ($allTrs as $tr) {
            $cells = [];
            foreach ($tr->childNodes as $cell) {
                if (!($cell instanceof \DOMElement)) continue;
                $cellTag = strtolower($cell->nodeName);
                if (!in_array($cellTag, ['td', 'th'])) continue;
                $cells[] = trim($this->nodeToText($cell));
            }

            if (count($cells) < 2) continue;

            $name  = $cells[0];
            $value = $cells[1];

            // Başlık satırını atla (iki hücre de sayısal değilse ve kısa metin ise başlık olabilir)
            if ($this->looksLikeCompositionHeader($name, $value)) continue;

            if (empty($name) && empty($value)) continue;

            // Yüzde işaretini temizle: "25%" → "25"
            $cleanValue = trim(str_replace('%', '', $value));

            $rows[] = [
                'name'       => $name,
                'percentage' => $cleanValue,
            ];
        }

        return $rows;
    }

    /**
     * Bileşim tablosu başlık satırı mı?
     *
     * Sadece NAME sütunu header kelimesi içeriyorsa header kabul et.
     * VALUE sütununu kullanmıyoruz çünkü "18%", "5%" gibi gerçek veri
     * hücrelerindeki % işareti yanlış eşleşmeye yol açıyor.
     *
     * Örnek:
     *   "Component | Percentage" → name="component" eşleşir → header ✓
     *   "Nitrogen (N) | 18%"    → name eşleşmez → veri satırı ✓
     */
    protected function looksLikeCompositionHeader(string $name, string $value): bool
    {
        $nameLower = mb_strtolower(trim($name), 'UTF-8');

        // Boş ad → header sayma
        if (empty($nameLower)) {
            return false;
        }

        // Sadece name sütununa bak
        $headerKeywords = [
            'bileşen', 'içerik', 'madde', 'bileşim',
            'component', 'ingredient', 'element',
            'özellik', 'property', 'parametre', 'parameter',
            'guaranteed', 'analiz', 'analysis',
        ];

        return $this->matchesKeywords($nameLower, $headerKeywords);
    }

    /**
     * Tablonun bileşim tablosuna benzeyip benzemediğini kontrol eder.
     * (Başlıksız içerik için)
     */
    protected function looksLikeCompositionTable(\DOMElement $table, array $headers): bool
    {
        // 2 sütunlu tablo → muhtemelen bileşim
        $firstRow = $table->getElementsByTagName('tr')->item(0);
        if (!$firstRow) return false;

        $cellCount = 0;
        foreach ($firstRow->childNodes as $cell) {
            if ($cell instanceof \DOMElement && in_array(strtolower($cell->nodeName), ['td', 'th'])) {
                $cellCount++;
            }
        }

        if ($cellCount === 2) {
            // 2 sütunlu tablo: ikinci hücrede sayı/yüzde var mı?
            $rows = $table->getElementsByTagName('tr');
            $numericCount = 0;
            foreach ($rows as $row) {
                $cells = [];
                foreach ($row->childNodes as $cell) {
                    if ($cell instanceof \DOMElement && in_array(strtolower($cell->nodeName), ['td', 'th'])) {
                        $cells[] = trim($this->nodeToText($cell));
                    }
                }
                if (count($cells) >= 2 && preg_match('/[\d.,]+/', $cells[1])) {
                    $numericCount++;
                }
            }
            return $numericCount >= 2;
        }

        return false;
    }

    // ─────────────────────────────────────────────────────────────────────
    // DOZAJ TABLOSU PARSE
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Section içindeki dozaj tablosunu parse eder.
     * Döndürür: dosage_items formatında dizi.
     */
    protected function parseDosageFromSection(array $section): array
    {
        foreach ($section['nodes'] as $node) {
            if ($node->nodeType !== XML_ELEMENT_NODE) continue;

            $tag = strtolower($node->nodeName);

            if ($tag === 'table') {
                $rows = $this->parseDosageTable($node);
                if (!empty($rows)) return $rows;
            }

            if (in_array($tag, ['figure', 'div'])) {
                $tables = $node->getElementsByTagName('table');
                foreach ($tables as $tbl) {
                    $rows = $this->parseDosageTable($tbl);
                    if (!empty($rows)) return $rows;
                }
            }
        }

        return [];
    }

    /**
     * Bir <table> elemanını dozaj_items formatına çevirir.
     *
     * Başlık eşleme mantığı:
     * 1) thead/th varsa → header'ları map'le
     * 2) th yoksa → ilk tr'yi header kabul et
     * 3) Header yoksa → sütun sırasını varsay (crop, sulama, yapraktan, topraktan, period, notes)
     */
    protected function parseDosageTable(\DOMElement $table): array
    {
        $rows       = [];
        $columnMap  = [];  // sütun_index => dosage_items_field
        $headerFound = false;

        $allTrs = $table->getElementsByTagName('tr');

        foreach ($allTrs as $trIndex => $tr) {
            $cells = $this->extractRowCells($tr);

            if (empty(array_filter($cells, fn($c) => $c !== ''))) continue;

            // Header satırı belirleme: th içeriyorsa veya ilk satırsa
            $hasTh = false;
            foreach ($tr->childNodes as $cell) {
                if ($cell instanceof \DOMElement && strtolower($cell->nodeName) === 'th') {
                    $hasTh = true;
                    break;
                }
            }

            if (!$headerFound && ($hasTh || $trIndex === 0)) {
                $columnMap   = $this->buildColumnMap($cells);
                $headerFound = true;

                // Eğer header'da bilinen dozaj alanı yoksa veri satırı olarak işle
                if (empty($columnMap)) {
                    // Varsayılan sütun sırası
                    $defaultOrder = [
                        0 => 'crop',
                        1 => 'sulama_dosage',
                        2 => 'yapraktan_dosage',
                        3 => 'topraktan_dosage',
                        4 => 'application_period',
                        5 => 'notes',
                    ];
                    $columnMap   = $defaultOrder;
                    $headerFound = true;

                    // Bu satırı veri olarak da işle
                    $row = $this->buildDosageRow($cells, $columnMap);
                    if (!$this->isDosageRowEmpty($row)) {
                        $rows[] = $row;
                    }
                }
                continue;
            }

            if (!$headerFound) continue;

            $row = $this->buildDosageRow($cells, $columnMap);
            if (!$this->isDosageRowEmpty($row)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Header hücrelerini dozaj alanlarına eşler.
     * Döndürür: [sütun_index => 'crop'|'sulama_dosage'|...]
     *
     * Eşleşme önceliği:
     * 1) dosageColumnMap tam eşleşme
     * 2) dosageColumnMap kısmi eşleşme
     * 3) Akıllı fallback: dozaj anahtar kelimesi içeriyorsa boş dose alanına ata
     */
    protected function buildColumnMap(array $headers): array
    {
        $map = [];

        foreach ($headers as $idx => $header) {
            $normalized = mb_strtolower(trim($header), 'UTF-8');
            $normalized = preg_replace('/\s+/', ' ', $normalized);

            // Tam eşleşme
            if (isset($this->dosageColumnMap[$normalized])) {
                $map[$idx] = $this->dosageColumnMap[$normalized];
                continue;
            }

            // Kısmi eşleşme
            foreach ($this->dosageColumnMap as $keyword => $field) {
                if (str_contains($normalized, $keyword) || str_contains($keyword, $normalized)) {
                    $map[$idx] = $field;
                    break;
                }
            }
        }

        // ─── AKILLI FALLBACK ─────────────────────────────────────────────
        // Eşleşemeyen sütun başlıkları içinde dozaj anahtar kelimeleri varsa
        // (dose, rate, kg, lt, usage vb.) boş dose alanlarına sırayla ata.
        // Örnek: "Usage Dose Kg / Decare" → sulama_dosage
        $doseFields   = ['sulama_dosage', 'yapraktan_dosage', 'topraktan_dosage'];
        $usedFields   = array_values($map);
        $doseKeywords = ['dose', 'dosage', 'rate', 'usage', 'amount', 'kg/da', 'kg/de',
                         'l/da', 'lt/da', 'ml/da', 'cc/da', 'g/da', 'decare', 'daa'];

        foreach ($headers as $idx => $header) {
            if (isset($map[$idx])) {
                continue; // Zaten eşleşti
            }
            $normalized = mb_strtolower(trim($header), 'UTF-8');
            if ($this->matchesKeywords($normalized, $doseKeywords)) {
                foreach ($doseFields as $doseField) {
                    if (!in_array($doseField, $usedFields)) {
                        $map[$idx]    = $doseField;
                        $usedFields[] = $doseField;
                        break;
                    }
                }
            }
        }

        return $map;
    }

    /**
     * Tek bir TR satırından dosage_items row oluşturur.
     */
    protected function buildDosageRow(array $cells, array $columnMap): array
    {
        $row = [
            'crop'               => '',
            'sulama_dosage'      => '',
            'yapraktan_dosage'   => '',
            'topraktan_dosage'   => '',
            'application_period' => '',
            'notes'              => '',
        ];

        foreach ($columnMap as $colIdx => $field) {
            if (isset($cells[$colIdx]) && $cells[$colIdx] !== '') {
                $row[$field] = $cells[$colIdx];
            }
        }

        return $row;
    }

    /**
     * Dozaj satırı tamamen boş mu?
     */
    protected function isDosageRowEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (!empty(trim((string) $value))) return false;
        }
        return true;
    }

    // ─────────────────────────────────────────────────────────────────────
    // YARDIMCI METODLAR
    // ─────────────────────────────────────────────────────────────────────

    /**
     * HTML string'i DOMDocument'e yükler.
     */
    protected function loadHtml(string $html): ?\DOMDocument
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');

        // Encoding güvenliği
        $html = '<div id="__wp_parse_root__">' . $html . '</div>';
        $html = '<?xml encoding="UTF-8">' . $html;

        libxml_use_internal_errors(true);
        $loaded = @$dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        return $loaded ? $dom : null;
    }

    /**
     * Metin keyword listesiyle eşleşiyor mu?
     */
    protected function matchesKeywords(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($text, mb_strtolower($keyword, 'UTF-8'))) {
                return true;
            }
        }
        return false;
    }

    /**
     * DOM node'dan düz metin çıkart (HTML tagları olmadan).
     */
    protected function nodeToText(\DOMNode $node): string
    {
        return trim($node->textContent ?? '');
    }

    /**
     * TR'deki tüm TD/TH hücrelerini metin dizisi olarak döndürür.
     */
    protected function extractRowCells(\DOMElement $tr): array
    {
        $cells = [];
        foreach ($tr->childNodes as $cell) {
            if (!($cell instanceof \DOMElement)) continue;
            if (!in_array(strtolower($cell->nodeName), ['td', 'th'])) continue;
            $cells[] = trim($this->nodeToText($cell));
        }
        return $cells;
    }

    /**
     * Tablonun header hücrelerini döndürür (thead/th veya ilk tr).
     */
    protected function extractTableHeaders(\DOMElement $table): array
    {
        // Önce thead içindeki th'lara bak
        $thead = $table->getElementsByTagName('thead');
        if ($thead->length > 0) {
            $ths = $thead->item(0)->getElementsByTagName('th');
            if ($ths->length > 0) {
                $headers = [];
                foreach ($ths as $th) {
                    $headers[] = trim($this->nodeToText($th));
                }
                return $headers;
            }
        }

        // İlk tr'yi header kabul et
        $trs = $table->getElementsByTagName('tr');
        if ($trs->length > 0) {
            return $this->extractRowCells($trs->item(0));
        }

        return [];
    }

    /**
     * Bir section'ı HTML string'e çevirir.
     */
    protected function sectionToHtml(array $section, bool $includeHeading): string
    {
        $parts = [];

        if ($includeHeading && !empty($section['heading'])) {
            $parts[] = '<h3>' . htmlspecialchars($section['heading'], ENT_QUOTES, 'UTF-8') . '</h3>';
        }

        foreach ($section['nodes'] as $node) {
            $parts[] = $this->outerHtml($node);
        }

        return implode("\n", $parts);
    }

    /**
     * DOMNode'un outer HTML'ini döndürür.
     */
    protected function outerHtml(\DOMNode $node): string
    {
        $dom = $node->ownerDocument;
        if (!$dom) return '';

        $html = '';
        foreach ($node->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }

        // Eğer nodeType element ise tam olarak kaydet
        if ($node->nodeType === XML_ELEMENT_NODE) {
            return $dom->saveHTML($node);
        }

        return $html;
    }

    /**
     * DOMElement'in inner HTML'ini döndürür.
     */
    protected function innerHtml(\DOMElement $element): string
    {
        $dom  = $element->ownerDocument;
        $html = '';
        foreach ($element->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }
        return $html;
    }

    /**
     * Tablolar haricindeki içeriği döndürür.
     */
    protected function extractNonTableContent(\DOMElement $wrapper, \DOMXPath $xpath): string
    {
        $parts = [];
        foreach ($wrapper->childNodes as $child) {
            if ($child->nodeType !== XML_ELEMENT_NODE) continue;
            $tag = strtolower($child->nodeName);
            if ($tag === 'table') continue;

            // Figure içinde table varsa atla
            if ($tag === 'figure') {
                $inner = $child->getElementsByTagName('table');
                if ($inner->length > 0) continue;
            }

            $childHtml = $this->outerHtml($child);
            if (!empty(trim(strip_tags($childHtml)))) {
                $parts[] = $childHtml;
            }
        }
        return implode("\n", $parts);
    }

    /**
     * HTML'i güvenli şekilde temizler (script/style kaldır, boşlukları düzenle).
     */
    protected function cleanHtml(string $html): string
    {
        // Script ve style taglarını kaldır
        $html = preg_replace('/<script\b[^>]*>[\s\S]*?<\/script>/i', '', $html);
        $html = preg_replace('/<style\b[^>]*>[\s\S]*?<\/style>/i', '', $html);

        // Çoklu boşlukları temizle
        $html = preg_replace('/\s{3,}/', ' ', $html);
        $html = trim($html);

        return $html;
    }

    // ─────────────────────────────────────────────────────────────────────
    // STATIK YARDIMCILAR
    // ─────────────────────────────────────────────────────────────────────

    /**
     * WooCommerce meta_data dizisinden belirli anahtarı bul.
     * $metaData = [{key: '...', value: '...'}, ...]
     */
    public static function findMetaValue(array $metaData, string ...$keys): mixed
    {
        foreach ($metaData as $meta) {
            if (!isset($meta['key'], $meta['value'])) continue;
            if (in_array($meta['key'], $keys, true) && !empty($meta['value'])) {
                return $meta['value'];
            }
        }
        return null;
    }
}
