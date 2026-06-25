<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Sayfa gösterimi
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Template'e göre doğru view'i seç.
        // template='contact' olan sayfalar iletişim formu içeren view ile render edilir —
        // böylece kullanıcı slug'ını istediği gibi (bize-ulasin, contact-us vs.) yazabilir.
        $view = match ($page->template) {
            'contact' => 'pages.contact',
            default   => 'pages.show',
        };

        return view($view, compact('page'));
    }

    /**
     * Root-level slug handler (/{slug})
     *
     * Admin'in menüde /ulasim gibi kısa link vermesini sağlar.
     * Öncelik sırası:
     *   1. Yayındaki bir Page varsa → sayfayı göster
     *   2. Bir kategori varsa → ProductController::category'ye devret
     *   3. Hiçbiri yoksa → 404
     */
    public function rootSlug(string $slug, Request $request)
    {
        // 1) Sayfa ara
        $page = Page::where('slug', $slug)->published()->first();
        if ($page) {
            $view = match ($page->template) {
                'contact' => 'pages.contact',
                default   => 'pages.show',
            };
            return view($view, compact('page'));
        }

        // 2) Kategoriye devret (eski davranış korunur)
        return app(\App\Http\Controllers\ProductController::class)->category($slug, $request);
    }
    
    /**
     * Hakkımızda sayfası
     */
    public function about()
    {
        // Yeni tasarım (pages.about) her zaman kullanılır; admin'in DB'deki
        // hakkımızda içeriği varsa $page olarak geçilir (view opsiyonel gösterir).
        $page = Page::where('slug', 'hakkimizda')->published()->first();
        return view('pages.about', compact('page'));
    }

    /**
     * İletişim sayfası
     *
     * Artık slug'a bağlı değil — template='contact' olan ilk yayında sayfayı bulur.
     * Böylece admin istediği slug'ı ('bize-ulasin', 'contact-us' vb.) yazabilir.
     * Geriye uyumluluk için slug='iletisim' de kabul edilir.
     */
    public function contact()
    {
        $page = Page::where(function ($q) {
                $q->where('template', 'contact')
                  ->orWhereIn('slug', ['iletisim', 'contact', 'contacto']);
            })
            ->published()
            ->first();

        if ($page) {
            return view('pages.contact', compact('page'));
        }
        return view('pages.contact');
    }

    /**
     * Gizlilik politikası
     */
    public function privacy()
    {
        $page = Page::where('slug', 'gizlilik-politikasi')->published()->first();
        if ($page) {
            return view('pages.show', compact('page'));
        }
        return view('pages.privacy');
    }

    /**
     * Kullanım şartları
     */
    public function terms()
    {
        $page = Page::where('slug', 'kullanim-sartlari')->published()->first();
        if ($page) {
            return view('pages.show', compact('page'));
        }
        return view('pages.terms');
    }
    
    /**
     * İletişim formu gönderimi (hem normal form hem bülten formu)
     */
    public function contactSubmit(Request $request)
    {
        $formType = $request->input('form_type', 'contact');

        // ── Bülten formu (ürün sayfasından) ──────────────────────────────
        if ($formType === 'newsletter') {
            $validated = $request->validate([
                'name'          => 'required|max:255',
                'email'         => 'required|email|max:255',
                'country'       => 'nullable|max:100',
                'company'       => 'nullable|max:255',
                'main_interest' => 'nullable|max:100',
                'activity'      => 'nullable|max:100',
                'accept_contact'=> 'required|accepted',
                'product_id'    => 'nullable|integer',
            ]);

            $extra = json_encode([
                'country'       => $validated['country']       ?? null,
                'company'       => $validated['company']       ?? null,
                'main_interest' => $validated['main_interest'] ?? null,
                'activity'      => $validated['activity']      ?? null,
                'product_id'    => $validated['product_id']    ?? null,
                'form_type'     => 'newsletter',
            ]);

            ContactForm::create([
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'subject'    => 'newsletter',
                'message'    => $extra,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            try {
                $toAddress = config('mail.to_address', config('mail.from.address'));
                Mail::send([], [], function ($message) use ($validated, $toAddress) {
                    $body  = "<h2>Yeni Bülten Kayıt Formu</h2>";
                    $body .= "<p><strong>Ad Soyad:</strong> " . htmlspecialchars($validated['name']) . "</p>";
                    $body .= "<p><strong>E-posta:</strong> " . htmlspecialchars($validated['email']) . "</p>";
                    $body .= "<p><strong>Ülke:</strong> " . htmlspecialchars($validated['country'] ?? '-') . "</p>";
                    $body .= "<p><strong>Şirket:</strong> " . htmlspecialchars($validated['company'] ?? '-') . "</p>";
                    $body .= "<p><strong>Ana İlgi:</strong> " . htmlspecialchars($validated['main_interest'] ?? '-') . "</p>";
                    $body .= "<p><strong>Faaliyet:</strong> " . htmlspecialchars($validated['activity'] ?? '-') . "</p>";
                    $body .= "<p><strong>Ürün ID:</strong> " . htmlspecialchars((string)($validated['product_id'] ?? '-')) . "</p>";

                    $message->to($toAddress)
                            ->replyTo($validated['email'], $validated['name'])
                            ->subject('Yeni Bülten Kaydı: ' . $validated['name'])
                            ->html($body);
                });
            } catch (\Exception $e) {
                // sessizce devam
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true]);
            }
            return redirect()->back()->with('success', 'Teşekkürler! Kaydınız alındı.');
        }

        // ── Normal iletişim formu ─────────────────────────────────────────
        $validated = $request->validate([
            'name'    => 'required|max:255',
            'company' => 'nullable|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|max:20',
            'subject' => 'required|in:general,product,dealer,support,other',
            'message' => 'required',
        ]);

        // 'company' tablo kolonu değil — mesaja önekle (form tasarımıyla birebir alan)
        $company = $validated['company'] ?? null;
        unset($validated['company']);
        if (!empty($company)) {
            $validated['message'] = '[Firma: ' . $company . "]\n" . $validated['message'];
        }

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        ContactForm::create($validated);

        try {
            $toAddress = config('mail.to_address', config('mail.from.address'));
            Mail::send([], [], function ($message) use ($validated, $toAddress) {
                $subject = match($validated['subject'] ?? 'other') {
                    'general' => 'Genel Bilgi',
                    'product' => 'Ürün Hakkında',
                    'dealer'  => 'Bayilik',
                    'support' => 'Teknik Destek',
                    default   => 'Diğer',
                };
                $body  = "<h2>Yeni İletişim Formu Mesajı</h2>";
                $body .= "<p><strong>Ad Soyad:</strong> " . htmlspecialchars($validated['name']) . "</p>";
                $body .= "<p><strong>E-posta:</strong> " . htmlspecialchars($validated['email']) . "</p>";
                $body .= "<p><strong>Telefon:</strong> " . htmlspecialchars($validated['phone'] ?? '-') . "</p>";
                $body .= "<p><strong>Konu:</strong> " . $subject . "</p>";
                $body .= "<p><strong>Mesaj:</strong><br>" . nl2br(htmlspecialchars($validated['message'])) . "</p>";

                $message->to($toAddress)
                        ->replyTo($validated['email'], $validated['name'])
                        ->subject('İletişim Formu: ' . $subject)
                        ->html($body);
            });
        } catch (\Exception $e) {
            // sessizce devam
        }

        return redirect(lroute('contact'))->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}