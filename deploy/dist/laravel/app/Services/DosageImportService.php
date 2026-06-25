<?php

namespace App\Services;

class DosageImportService
{
    /**
     * Header eşleme tablosu: kullanıcının yazdığı → alan adı
     */
    protected array $headerMap = [
        // crop
        'bitki'              => 'crop',
        'bitki adı'          => 'crop',
        'bitki adi'          => 'crop',
        'bitki/ürün'         => 'crop',
        'bitki/urun'         => 'crop',
        'ürün'               => 'crop',
        'urun'               => 'crop',
        'crop'               => 'crop',

        // sulama_dosage
        'sulama'             => 'sulama_dosage',
        'sulama dozu'        => 'sulama_dosage',
        'sulama uygulama'    => 'sulama_dosage',
        'damlama'            => 'sulama_dosage',

        // yapraktan_dosage
        'yapraktan'          => 'yapraktan_dosage',
        'yapraktan dozu'     => 'yapraktan_dosage',
        'yapraktan uygulama' => 'yapraktan_dosage',

        // topraktan_dosage
        'topraktan'          => 'topraktan_dosage',
        'topraktan dozu'     => 'topraktan_dosage',
        'topraktan uygulama' => 'topraktan_dosage',

        // application_period
        'uygulama zamanı'    => 'application_period',
        'uygulama zamani'    => 'application_period',
        'uygulama dönemi'    => 'application_period',
        'uygulama donemi'    => 'application_period',
        'dönem'              => 'application_period',
        'donem'              => 'application_period',
        'zaman'              => 'application_period',

        // notes
        'not'                => 'notes',
        'notlar'             => 'notes',
        'açıklama'           => 'notes',
        'aciklama'           => 'notes',
    ];

    /**
     * Yapıştırılan metni parse et.
     * Web sayfasından veya Excel'den kopyalanan tablo verisini destekler.
     */
    public function parsePastedText(string $text): array
    {
        $text = $this->stripBom(trim($text));

        if (empty($text)) {
            return [];
        }

        $lines = preg_split('/\r?\n/', $text);
        $lines = array_filter($lines, fn($line) => trim($line) !== '');
        $lines = array_values($lines);

        if (count($lines) < 2) {
            // Tek satır: header bile yok veya sadece header var, veri satırı yok
            // Belki headersız veri yapıştırmış olabilir, direkt veri olarak dene
            return $this->parseWithoutHeaders($lines);
        }

        // İlk satır header mı kontrol et
        $firstLineDelimiter = $this->detectLineDelimiter($lines[0]);
        $firstCells = $this->splitLine($lines[0], $firstLineDelimiter);
        $mappedHeaders = $this->mapHeaders($firstCells);

        $hasKnownHeader = false;
        foreach ($mappedHeaders as $field) {
            if ($field !== null) {
                $hasKnownHeader = true;
                break;
            }
        }

        if ($hasKnownHeader) {
            return $this->parseWithHeaders($lines, $firstLineDelimiter, $firstCells, $mappedHeaders);
        }

        // Header tanınmadı - tüm satırları veri olarak al
        return $this->parseWithoutHeaders($lines);
    }

    /**
     * Başlıklı tablo verisini parse et.
     */
    protected function parseWithHeaders(array $lines, string $delimiter, array $headers, array $mappedHeaders): array
    {
        $rows = [];

        for ($i = 1; $i < count($lines); $i++) {
            $cells = $this->splitLine($lines[$i], $delimiter);
            $row = $this->buildEmptyRow();

            foreach ($cells as $colIndex => $value) {
                if (isset($headers[$colIndex])) {
                    $field = $mappedHeaders[$headers[$colIndex]] ?? null;
                    if ($field) {
                        $row[$field] = trim($value);
                    }
                }
            }

            if (!$this->isRowEmpty($row)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Başlıksız veriyi parse et.
     * Sütun sayısına göre akıllı eşleme yapar.
     */
    protected function parseWithoutHeaders(array $lines): array
    {
        $rows = [];
        $delimiter = $this->detectLineDelimiter($lines[0] ?? '');

        // Sütun sırası varsayımı: Bitki, Sulama, Yapraktan, Topraktan, Uygulama Zamanı, Not
        $fieldOrder = ['crop', 'sulama_dosage', 'yapraktan_dosage', 'topraktan_dosage', 'application_period', 'notes'];

        foreach ($lines as $line) {
            $cells = $this->splitLine($line, $delimiter);
            $row = $this->buildEmptyRow();

            foreach ($cells as $colIndex => $value) {
                if (isset($fieldOrder[$colIndex])) {
                    $row[$fieldOrder[$colIndex]] = trim($value);
                }
            }

            if (!$this->isRowEmpty($row)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Manuel sütun eşleme ile parse et.
     * $columnMap: ['crop' => 1, 'topraktan_dosage' => 3, ...] (1-tabanlı sütun numaraları)
     */
    public function parseWithManualMapping(string $text, array $columnMap, bool $skipHeader = true): array
    {
        $text = $this->stripBom(trim($text));

        if (empty($text)) {
            return [];
        }

        $lines = preg_split('/\r?\n/', $text);
        $lines = array_filter($lines, fn($line) => trim($line) !== '');
        $lines = array_values($lines);

        $delimiter = $this->detectLineDelimiter($lines[0] ?? '');

        $rows = [];
        $startIndex = $skipHeader ? 1 : 0;

        for ($i = $startIndex; $i < count($lines); $i++) {
            $cells = $this->splitLine($lines[$i], $delimiter);
            $row = $this->buildEmptyRow();

            foreach ($columnMap as $field => $colNum) {
                $colIndex = $colNum - 1; // 1-tabanlı → 0-tabanlı
                if (isset($cells[$colIndex])) {
                    $row[$field] = trim($cells[$colIndex]);
                }
            }

            if (!$this->isRowEmpty($row)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Header dizisini alan adlarına eşle.
     */
    public function mapHeaders(array $headers): array
    {
        $mapped = [];
        foreach ($headers as $header) {
            $normalized = $this->normalizeHeader($header);
            $mapped[$header] = $this->headerMap[$normalized] ?? null;
        }
        return $mapped;
    }

    /**
     * Satırı delimiter'a göre böl.
     */
    protected function splitLine(string $line, string $delimiter): array
    {
        $cells = explode($delimiter, $line);
        return array_map('trim', $cells);
    }

    /**
     * Satırdaki delimiter'ı algıla: TAB > | > ; > ,
     */
    protected function detectLineDelimiter(string $line): string
    {
        $tabCount  = substr_count($line, "\t");
        $pipeCount = substr_count($line, '|');
        $semiCount = substr_count($line, ';');
        $commaCount = substr_count($line, ',');

        // TAB en güvenilir (Excel/web tablodan kopyalama genelde TAB üretir)
        if ($tabCount >= 1 && $tabCount >= $pipeCount && $tabCount >= $semiCount) {
            return "\t";
        }
        if ($pipeCount >= 2) {
            return '|';
        }
        if ($semiCount >= 1 && $semiCount >= $commaCount) {
            return ';';
        }
        if ($commaCount >= 1) {
            return ',';
        }

        return "\t";
    }

    /**
     * Header'ı normalize et.
     */
    protected function normalizeHeader(string $header): string
    {
        $header = $this->stripBom($header);
        $header = mb_strtolower(trim($header));
        $header = preg_replace('/\s+/', ' ', $header);
        return $header;
    }

    /**
     * Boş satır şablonu.
     */
    protected function buildEmptyRow(): array
    {
        return [
            'crop'               => '',
            'sulama_dosage'      => '',
            'yapraktan_dosage'   => '',
            'topraktan_dosage'   => '',
            'application_period' => '',
            'notes'              => '',
        ];
    }

    /**
     * Satırın tamamen boş olup olmadığını kontrol et.
     */
    protected function isRowEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== '' && $value !== null) {
                return false;
            }
        }
        return true;
    }

    /**
     * UTF-8 BOM temizle.
     */
    protected function stripBom(string $text): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $text);
    }
}
