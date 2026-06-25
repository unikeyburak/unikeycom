@extends('layouts.app')

@php $page = $page ?? null; @endphp

@section('title', isset($page) ? ($page->meta_title ?? $page->title . ' - Keysol Agro') : 'İletişim - Keysol Agro')
@section('meta_description', isset($page) && $page->meta_description ? $page->meta_description : ($settings['site_description'] ?? ''))

@section('content')

{{-- YEŞİL BAŞLIK BANDI --}}
<div class="hero-band bg-earth-600">
    <div class="mx-auto max-w-6xl px-5 pb-16 pt-4 lg:pb-24 lg:pt-8">
        <nav aria-label="breadcrumb" class="mb-5 flex flex-wrap items-center gap-2 text-sm text-white/60">
            <a href="{{ route('home') }}" class="transition hover:text-white">Ana Sayfa</a>
            <span aria-hidden="true">/</span>
            <span class="text-white/90">İletişim</span>
        </nav>
        <span class="text-sm font-bold uppercase tracking-[0.12em] text-leaf-300">Bize Ulaşın</span>
        <h1 class="mt-3 max-w-2xl text-[clamp(2.2rem,4.5vw,3.4rem)] font-medium leading-[1.08] tracking-tight text-white">Konuşalım — tarladaki bir sonraki adımı birlikte planlayalım</h1>
    </div>
</div>

{{-- İLETİŞİM: form + bilgiler --}}
<section class="mx-auto max-w-6xl px-5 py-16 lg:py-20">
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-16">

        {{-- form --}}
        <div class="lg:col-span-7">
            <h2 class="text-2xl font-extrabold tracking-tight text-ink lg:text-3xl">Mesaj gönderin</h2>
            <p class="mt-2 text-[15px] leading-relaxed text-ink-soft">Formu doldurun, agronomi ekibimiz en kısa sürede dönüş yapsın.</p>

            @if(session('success'))
                <div class="mt-6 rounded-lg border border-leaf-500/30 bg-leaf-500/10 px-4 py-3 text-[15px] font-semibold text-leaf-700">{{ session('success') }}</div>
            @endif

            <form action="{{ lroute('contact.submit') }}" method="POST" class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2">
                @csrf
                <div>
                    <label for="f-name" class="mb-1.5 block text-sm font-bold text-ink">Ad Soyad</label>
                    <input id="f-name" name="name" type="text" required value="{{ old('name') }}" placeholder="Adınız" class="w-full rounded-lg border border-hair px-4 py-3 text-[15px] outline-none transition focus:border-leaf-500 focus:ring-2 focus:ring-leaf-300/40">
                    @error('name')<p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="f-company" class="mb-1.5 block text-sm font-bold text-ink">Firma / İşletme</label>
                    <input id="f-company" name="company" type="text" value="{{ old('company') }}" placeholder="İşletmeniz" class="w-full rounded-lg border border-hair px-4 py-3 text-[15px] outline-none transition focus:border-leaf-500 focus:ring-2 focus:ring-leaf-300/40">
                </div>
                <div>
                    <label for="f-email" class="mb-1.5 block text-sm font-bold text-ink">E-posta</label>
                    <input id="f-email" name="email" type="email" required value="{{ old('email') }}" placeholder="ornek@eposta.com" class="w-full rounded-lg border border-hair px-4 py-3 text-[15px] outline-none transition focus:border-leaf-500 focus:ring-2 focus:ring-leaf-300/40">
                    @error('email')<p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="f-phone" class="mb-1.5 block text-sm font-bold text-ink">Telefon</label>
                    <input id="f-phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+90 ..." class="w-full rounded-lg border border-hair px-4 py-3 text-[15px] outline-none transition focus:border-leaf-500 focus:ring-2 focus:ring-leaf-300/40">
                </div>
                <div class="sm:col-span-2">
                    <label for="f-subject" class="mb-1.5 block text-sm font-bold text-ink">Konu</label>
                    <select id="f-subject" name="subject" class="w-full rounded-lg border border-hair bg-white px-4 py-3 text-[15px] outline-none transition focus:border-leaf-500 focus:ring-2 focus:ring-leaf-300/40">
                        <option value="product" {{ old('subject') === 'product' ? 'selected' : '' }}>Ürün danışmanlığı</option>
                        <option value="general" {{ old('subject') === 'general' ? 'selected' : '' }}>Teklif talebi</option>
                        <option value="dealer" {{ old('subject') === 'dealer' ? 'selected' : '' }}>Bayilik başvurusu</option>
                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>İhracat / iş birliği</option>
                        <option value="support" {{ old('subject') === 'support' ? 'selected' : '' }}>Diğer</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="f-msg" class="mb-1.5 block text-sm font-bold text-ink">Mesajınız</label>
                    <textarea id="f-msg" name="message" rows="5" required placeholder="Kültürünüz, alan büyüklüğünüz ve ihtiyacınızı kısaca yazın..." class="w-full rounded-lg border border-hair px-4 py-3 text-[15px] outline-none transition focus:border-leaf-500 focus:ring-2 focus:ring-leaf-300/40">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-leaf-600 px-7 py-3.5 text-base font-extrabold text-white transition hover:bg-leaf-700">
                        Gönder <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- bilgiler --}}
        <div class="lg:col-span-5">
            <h2 class="text-2xl font-extrabold tracking-tight text-ink lg:text-3xl">İletişim bilgileri</h2>
            <div class="mt-8 space-y-6">
                <div class="flex items-start gap-4">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-leaf-500/10 text-leaf-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
                    <div>
                        <h3 class="font-extrabold text-ink">Adres</h3>
                        <p class="mt-1 text-[15px] leading-relaxed text-ink-soft">Antalya Organize Sanayi Bölgesi<br>2. Kısım, 10. Cadde No: 5, Antalya / Türkiye</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-leaf-500/10 text-leaf-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg></span>
                    <div>
                        <h3 class="font-extrabold text-ink">Telefon</h3>
                        <p class="mt-1 text-[15px] leading-relaxed text-ink-soft"><a href="tel:+902420000000" class="transition hover:text-leaf-700">+90 242 000 00 00</a><br><a href="tel:+908500000000" class="transition hover:text-leaf-700">0850 000 00 00</a></p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-leaf-500/10 text-leaf-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg></span>
                    <div>
                        <h3 class="font-extrabold text-ink">E-posta</h3>
                        <p class="mt-1 text-[15px] leading-relaxed text-ink-soft"><a href="mailto:info@keysolagro.com" class="transition hover:text-leaf-700">info@keysolagro.com</a><br><a href="mailto:ihracat@keysolagro.com" class="transition hover:text-leaf-700">ihracat@keysolagro.com</a></p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-leaf-500/10 text-leaf-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></span>
                    <div>
                        <h3 class="font-extrabold text-ink">Çalışma Saatleri</h3>
                        <p class="mt-1 text-[15px] leading-relaxed text-ink-soft">Pazartesi – Cuma: 08:30 – 18:00<br>Cumartesi: 09:00 – 13:00</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <a href="https://www.instagram.com/stories/unikeyterrachemical/" target="_blank" rel="noopener" class="story-ring shrink-0" style="width:44px;height:44px;padding:3px" aria-label="Instagram hikayelerimizi izle" title="Hikayemizi izle"><span class="story-ring__avatar"><img src="{{ asset('images/leaf.png') }}" alt=""></span></a>
                    <div>
                        <h3 class="font-extrabold text-ink">Instagram</h3>
                        <p class="mt-1 text-[15px] leading-relaxed text-ink-soft">Sahadan kareler ve güncel hikayeler için<br><a href="https://www.instagram.com/unikeyterrachemical/" target="_blank" rel="noopener" class="font-semibold text-leaf-700 transition hover:text-leaf-600">@unikeyterrachemical</a> hesabımızı takip edin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- HARİTA (stilize) --}}
<section class="mx-auto max-w-6xl px-5 pb-16 lg:pb-20">
    <div class="relative grid h-72 place-items-center overflow-hidden rounded-2xl bg-leaf-500/5 ring-1 ring-hair lg:h-96">
        <div class="flex flex-col items-center text-center">
            <span class="relative grid h-14 w-14 place-items-center">
                <span class="absolute h-14 w-14 animate-ping rounded-full bg-leaf-500/30" aria-hidden="true"></span>
                <span class="grid h-11 w-11 place-items-center rounded-full bg-leaf-600 text-white shadow-lg"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
            </span>
            <span class="mt-3 rounded-lg bg-white px-4 py-2 text-sm font-bold text-ink shadow-sm">Keysol Agro · Antalya OSB</span>
        </div>
    </div>
</section>

@endsection
