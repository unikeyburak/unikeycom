<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $query = Catalog::published()->orderBy('sort_order')->orderBy('published_at', 'desc');

        // Dil filtresi
        $language = $request->get('dil');
        if ($language) {
            $query->where('language', $language);
        }

        $catalogs = $query->get();

        // Mevcut dilleri bul
        $availableLanguages = Catalog::published()
            ->select('language')
            ->distinct()
            ->pluck('language');

        $meta = [
            'title'       => __('Kataloglar') . ' - ' . config('app.name'),
            'description' => __('Ürün kataloglarımızı indirin ve inceleyin.'),
            'keywords'    => __('katalog, ürün kataloğu, PDF, tarım kataloğu'),
        ];

        return view('catalogs.index', compact('catalogs', 'availableLanguages', 'language', 'meta'));
    }

    public function show(string $slug)
    {
        $catalog = Catalog::published()->where('slug', $slug)->firstOrFail();

        $meta = [
            'title'       => ($catalog->translate('title') ?? $catalog->title) . ' - ' . config('app.name'),
            'description' => $catalog->translate('description') ?? $catalog->description ?? '',
        ];

        return view('catalogs.show', compact('catalog', 'meta'));
    }

    public function viewPdf(string $slug)
    {
        $catalog = Catalog::published()->where('slug', $slug)->firstOrFail();

        if (!$catalog->file_path || !Storage::disk('public')->exists($catalog->file_path)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($catalog->file_path);

        return response()->file($path, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . \Illuminate\Support\Str::slug($catalog->title) . '.pdf"',
            'X-Frame-Options'     => 'SAMEORIGIN',
        ]);
    }

    public function download(string $slug)
    {
        $catalog = Catalog::published()->where('slug', $slug)->firstOrFail();

        if (!$catalog->file_path || !Storage::disk('public')->exists($catalog->file_path)) {
            abort(404, 'Katalog dosyası bulunamadı.');
        }

        // İndirme sayacını artır
        $catalog->incrementDownloadCount();

        $fileName = \Illuminate\Support\Str::slug($catalog->title) . '.pdf';

        return Storage::disk('public')->download($catalog->file_path, $fileName);
    }
}
