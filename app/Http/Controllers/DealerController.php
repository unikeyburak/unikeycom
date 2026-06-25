<?php

namespace App\Http\Controllers;

use App\Services\DealerService;
use App\Models\Dealer;
use App\Models\DealerUser;
use App\DTO\DealerDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\DealerRegistrationMail;
use App\Mail\NewQuoteRequestMail;
use App\Mail\DealerPasswordResetMail;
use Illuminate\Support\Str;

class DealerController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(
        private DealerService $dealerService
    ) {}

    /**
     * Bayi listesi
     */
    public function index(Request $request)
    {
        $dealers = $this->dealerService->getActiveDealers(
            perPage: 12,
            city: $request->get('city'),
            search: $request->get('q')
        );
        
        $cities = $this->dealerService->getCities();
        
        return view('dealers.index', compact('dealers', 'cities'));
    }
    
    /**
     * Bayi giriş sayfası
     */
    public function login()
    {
        if (Auth::guard('dealer')->check()) {
            return redirect()->route('dealer.dashboard');
        }
        
        return view('dealer.login');
    }
    
    /**
     * Bayi giriş işlemi
     */
    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // DealerUser'ı bul
        $dealerUser = DealerUser::where('email', $credentials['email'])->first();
        
        if (!$dealerUser || !Hash::check($credentials['password'], $dealerUser->password)) {
            return back()->withErrors([
                'email' => 'E-posta veya şifre hatalı.',
            ])->withInput($request->only('email'));
        }
        
        // Kullanıcı ve bayi aktif mi kontrol et
        if (!$dealerUser->is_active) {
            return back()->withErrors([
                'email' => 'Hesabınız aktif değil.',
            ])->withInput($request->only('email'));
        }
        
        if (!$dealerUser->dealer->is_active) {
            return back()->withErrors([
                'email' => 'Bayi hesabınız aktif değil. Lütfen yöneticiyle iletişime geçin.',
            ])->withInput($request->only('email'));
        }
        
        // Giriş yap
        Auth::guard('dealer')->login($dealerUser, $request->boolean('remember'));
        
        // Son giriş bilgilerini güncelle
        $dealerUser->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);
        
        return redirect()->intended(route('dealer.dashboard'));
    }
    
    /**
     * Bayi çıkış
     */
    public function logout()
    {
        Auth::guard('dealer')->logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect()->route('dealer.login');
    }
    
    /**
     * Bayi kayıt sayfası
     */
    public function register()
    {
        return view('dealer.register');
    }
    
    /**
     * Bayi kayıt işlemi
     */
    public function registerSubmit(Request $request)
    {
        $validated = $request->validate([
            // Şirket bilgileri
            'company_name' => 'required|string|max:255',
            'tax_number' => 'required|string|max:20|unique:dealers,tax_number',
            'tax_office' => 'required|string|max:255',
            
            // İletişim bilgileri
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:dealer_users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            
            // Adres bilgileri
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            
            // Opsiyonel
            'website' => 'nullable|url|max:255',
            'about' => 'nullable|string',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Bayi oluştur
            $dealer = Dealer::create([
                'company_name' => $validated['company_name'],
                'tax_number' => $validated['tax_number'],
                'tax_office' => $validated['tax_office'],
                'contact_name' => $validated['contact_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'whatsapp' => $validated['whatsapp'] ?? $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'district' => $validated['district'],
                'postal_code' => $validated['postal_code'],
                'website' => $validated['website'],
                'about' => $validated['about'],
                'is_active' => false, // Onay bekliyor
                'is_verified' => false,
            ]);
            
            // Bayi kullanıcısı oluştur
            $dealerUser = $dealer->dealerUsers()->create([
                'name' => $validated['contact_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'role' => 'owner', // İlk kullanıcı owner olur
                'is_active' => true,
            ]);
            
            DB::commit();
            
            // Admin'e e-posta gönder
            $adminEmails = config('mail.admin_emails', ['admin@unikeyterra.com']);
            foreach ($adminEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new DealerRegistrationMail($dealer));
            }
            
            return redirect()->route('dealer.login')
                ->with('success', 'Bayi başvurunuz alındı. Onaylandıktan sonra giriş yapabilirsiniz.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors([
                'email' => 'Kayıt işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.'
            ])->withInput();
        }
    }
    
    /**
     * Bayi paneli - Dashboard
     */
    public function dashboard()
    {
        $dealer = Auth::guard('dealer')->user()->dealer;
        
        // İstatistikler
        $stats = [
            'pending_quotes' => $dealer->quoteRequests()->where('status', 'pending')->count(),
            'total_quotes' => $dealer->quoteRequests()->count(),
            'available_credit' => $dealer->credit_limit - ($dealer->used_credit ?? 0),
        ];
        
        // Son teklif talepleri
        $recentQuotes = $dealer->quoteRequests()
            ->with(['product'])
            ->latest()
            ->limit(5)
            ->get();
        
        return view('dealer.dashboard', compact('dealer', 'stats', 'recentQuotes'));
    }
    
    /**
     * Bayi profili
     */
    public function profile()
    {
        $user = Auth::guard('dealer')->user();
        $dealer = $user->dealer;
        
        return view('dealer.profile', compact('user', 'dealer'));
    }
    
    /**
     * Bayi profil güncelleme
     */
    public function profileUpdate(Request $request)
    {
        $dealerUser = Auth::guard('dealer')->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:dealer_users,email,' . $dealerUser->id,
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        // Şifre güncelleme
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $dealerUser->password)) {
                return back()->withErrors([
                    'current_password' => 'Mevcut şifreniz hatalı.'
                ]);
            }
            
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        unset($validated['current_password']);
        
        $dealerUser->update($validated);
        
        return back()->with('success', 'Profil bilgileriniz güncellendi.');
    }
    
    /**
     * Bayi firma bilgileri
     */
    public function company()
    {
        $dealer = Auth::guard('dealer')->user()->dealer;
        return view('dealer.company', compact('dealer'));
    }
    
    /**
     * Bayi firma bilgileri güncelleme
     */
    public function companyUpdate(Request $request)
    {
        $dealer = Auth::guard('dealer')->user()->dealer;
        
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'tax_number' => 'required|string|max:20|unique:dealers,tax_number,' . $dealer->id,
            'tax_office' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'about' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);
        
        $dealer->update($validated);
        
        return back()->with('success', 'Firma bilgileriniz güncellendi.');
    }
    
    /**
     * Bayi teklifleri listesi
     */
    public function quotes(Request $request)
    {
        $dealer = Auth::guard('dealer')->user()->dealer;
        
        $quotes = $dealer->quoteRequests()
            ->with(['product'])
            ->when($request->filled('status'), function($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('start_date'), function($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->end_date);
            })
            ->latest()
            ->paginate(10);
        
        return view('dealer.quotes.index', compact('quotes'));
    }
    
    /**
     * Teklif detayı
     */
    public function quotesShow($id)
    {
        $dealer = Auth::guard('dealer')->user()->dealer;
        
        $quote = $dealer->quoteRequests()
            ->with(['product', 'product.category'])
            ->findOrFail($id);
        
        return view('dealer.quotes.show', compact('quote'));
    }
    
    /**
     * Teklif iptali
     */
    public function quotesCancel($id)
    {
        $dealer = Auth::guard('dealer')->user()->dealer;
        
        $quote = $dealer->quoteRequests()
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $quote->update(['status' => 'cancelled']);
        
        // Durum geçmişi
        $history = $quote->status_history ?? [];
        $history[] = [
            'status' => 'cancelled',
            'date' => now()->toISOString(),
            'note' => 'Bayi tarafından iptal edildi'
        ];
        $quote->update(['status_history' => $history]);
        
        return redirect()->route('dealer.quotes')->with('success', 'Teklif talebi iptal edildi.');
    }
    
    /**
     * Bayi ürünler listesi
     */
    public function products(Request $request)
    {
        $products = \App\Models\Product::with(['category.translations'])
            ->where('is_active', true)
            ->when($request->filled('search'), function($query) use ($request) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('active_ingredient', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function($query) use ($request) {
                $catId = $request->category;
                $query->where(function ($q) use ($catId) {
                    $q->where('category_id', $catId)
                      ->orWhereHas('categories', fn ($sub) => $sub->where('categories.id', $catId));
                });
            })
            ->when($request->filled('sort'), function($query) use ($request) {
                switch ($request->sort) {
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'newest':
                        $query->latest();
                        break;
                    default:
                        $query->orderBy('name', 'asc');
                }
            }, function($query) {
                $query->orderBy('name', 'asc');
            })
            ->paginate(12);
        
        $categories = \App\Models\Category::where('is_active', true)
            ->with('translations')
            ->orderBy('name')
            ->get();
        
        return view('dealer.products.index', compact('products', 'categories'));
    }
    
    /**
     * Ürün detayı (bayi görünümü)
     */
    public function productsShow(\App\Models\Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        
        $productCatIds = $product->categories()->pluck('categories.id')->toArray();
        if (empty($productCatIds)) {
            $productCatIds = $product->category_id ? [$product->category_id] : [];
        }

        $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where(function ($q) use ($productCatIds) {
                $q->whereIn('category_id', $productCatIds)
                  ->orWhereHas('categories', fn ($sub) => $sub->whereIn('categories.id', $productCatIds));
            })
            ->limit(4)
            ->get();
        
        return view('dealer.products.show', compact('product', 'relatedProducts'));
    }
    
    /**
     * Ürün teklif formu
     */
    public function productsQuote(\App\Models\Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        
        return view('dealer.products.quote', compact('product'));
    }
    
    /**
     * Ürün teklif talebi gönderme
     */
    public function productsQuoteSubmit(Request $request, \App\Models\Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        
        $dealer = Auth::guard('dealer')->user()->dealer;
        
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:1',
            'unit' => 'required|string|in:Adet,Kg,Lt,Ton,Paket',
            'delivery_city' => 'required|string|max:100',
            'delivery_date' => 'nullable|date|after:today',
            'usage_purpose' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|in:Nakit,Vadeli,Kredi Kartı,Havale/EFT',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $quote = $dealer->quoteRequests()->create([
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'delivery_city' => $validated['delivery_city'],
            'delivery_date' => $validated['delivery_date'],
            'usage_purpose' => $validated['usage_purpose'],
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'status_history' => [[
                'status' => 'pending',
                'date' => now()->toISOString(),
                'note' => 'Teklif talebi oluşturuldu'
            ]]
        ]);
        
        // Admin'e e-posta gönder
        $adminEmails = config('mail.admin_emails', ['info@unikeyterra.com']);
        foreach ($adminEmails as $adminEmail) {
            Mail::to($adminEmail)->send(new NewQuoteRequestMail($quote));
        }
        
        return redirect()->route('dealer.quotes.show', $quote)
            ->with('success', 'Teklif talebiniz başarıyla oluşturuldu. En kısa sürede size dönüş yapılacaktır.');
    }
    
    /**
     * Şifremi unuttum formu
     */
    public function forgotPassword()
    {
        return view('dealer.forgot-password');
    }
    
    /**
     * Şifre sıfırlama linki gönder
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:dealer_users,email',
        ], [
            'email.exists' => 'Bu e-posta adresi ile kayıtlı bir bayi bulunamadı.',
        ]);
        
        $dealerUser = DealerUser::where('email', $request->email)->first();
        
        // Token oluştur
        $token = Str::random(64);
        
        // Token'ı veritabanına kaydet
        $dealerUser->update([
            'password_reset_token' => $token,
            'password_reset_expires' => now()->addHour(),
        ]);
        
        // Reset URL'i oluştur
        $resetUrl = route('dealer.password.reset', ['token' => $token, 'email' => $dealerUser->email]);
        
        // E-posta gönder
        Mail::to($dealerUser->email)->send(new DealerPasswordResetMail($dealerUser, $resetUrl));
        
        return back()->with('success', 'Şifre sıfırlama linki e-posta adresinize gönderildi.');
    }
    
    /**
     * Şifre sıfırlama formu
     */
    public function resetPasswordForm(Request $request)
    {
        $token = $request->route('token');
        $email = $request->get('email');
        
        if (!$token || !$email) {
            return redirect()->route('dealer.login')->with('error', 'Geçersiz şifre sıfırlama linki.');
        }
        
        $dealerUser = DealerUser::where('email', $email)
            ->where('password_reset_token', $token)
            ->where('password_reset_expires', '>', now())
            ->first();
            
        if (!$dealerUser) {
            return redirect()->route('dealer.login')->with('error', 'Şifre sıfırlama linki geçersiz veya süresi dolmuş.');
        }
        
        return view('dealer.reset-password', compact('token', 'email'));
    }
    
    /**
     * Şifreyi sıfırla
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:dealer_users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $dealerUser = DealerUser::where('email', $request->email)
            ->where('password_reset_token', $request->token)
            ->where('password_reset_expires', '>', now())
            ->first();
            
        if (!$dealerUser) {
            return back()->with('error', 'Şifre sıfırlama linki geçersiz veya süresi dolmuş.');
        }
        
        // Şifreyi güncelle
        $dealerUser->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'password_reset_expires' => null,
        ]);
        
        return redirect()->route('dealer.login')->with('success', 'Şifreniz başarıyla güncellendi. Yeni şifrenizle giriş yapabilirsiniz.');
    }
}