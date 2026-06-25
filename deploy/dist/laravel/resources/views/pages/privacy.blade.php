@extends('layouts.app')

@section('title', 'Privacy Policy — Keysol Agro')
@section('meta_description', 'Keysol Agro Privacy Policy — how we collect, use and protect your personal data when you visit our website or contact us.')

@section('content')

@include('partials.page-header', [
    'title'    => __('Gizlilik Politikası'),
    'subtitle' => __('Son güncelleme: ') . date('d.m.Y'),
    'image'    => null,
    'size'     => 'small',
    'overlay'  => false,
])

{{-- ─────────────────────────────────────────────
     CONTENT
───────────────────────────────────────────── --}}
<section style="background:#fff; padding:80px 0;">
    <div class="container mx-auto px-6">
        <div style="max-width:760px; margin:0 auto;">

            {{-- Intro --}}
            <p style="font-size:1.05rem; line-height:1.85; color:#374151; margin-bottom:2.5rem; padding-bottom:2.5rem; border-bottom:1px solid #e5e7eb;">
                Keysol Agro ("<strong>we</strong>", "<strong>us</strong>" or "<strong>our</strong>") is committed to protecting your privacy.
                This Privacy Policy explains what personal data we collect when you visit
                <strong>{{ config('app.url') }}</strong>, how we use it and what rights you have.
                By using our website you agree to the practices described below.
            </p>

            {{-- Section 1 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">1</span>
                    Information We Collect
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1rem;">
                    We may collect the following categories of personal data:
                </p>
                <ul style="color:#4b5563; line-height:1.9; padding-left:1.25rem; display:flex; flex-direction:column; gap:.4rem;">
                    <li><strong style="color:#111827;">Contact details</strong> — name, e-mail address and phone number submitted via the contact form.</li>
                    <li><strong style="color:#111827;">Business information</strong> — company name, tax number and address provided during dealer registration.</li>
                    <li><strong style="color:#111827;">Technical data</strong> — IP address, browser type, operating system and pages visited, collected automatically.</li>
                    <li><strong style="color:#111827;">Cookie data</strong> — usage preferences and session identifiers stored in cookies (see Section 5).</li>
                </ul>
            </div>

            {{-- Section 2 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">2</span>
                    How We Use Your Information
                </h2>
                <ul style="color:#4b5563; line-height:1.9; padding-left:1.25rem; display:flex; flex-direction:column; gap:.4rem;">
                    <li>To respond to your enquiries and provide requested information about our products.</li>
                    <li>To process dealer applications and manage dealer portal accounts.</li>
                    <li>To improve website performance, content and user experience.</li>
                    <li>To comply with applicable legal obligations.</li>
                    <li>To send service-related communications (no marketing e-mails without your consent).</li>
                </ul>
            </div>

            {{-- Section 3 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">3</span>
                    Data Security
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    We implement appropriate technical and organisational measures to protect your personal data
                    against unauthorised access, accidental loss, destruction or disclosure.
                    All data transmissions between your browser and our server are encrypted via HTTPS.
                </p>
            </div>

            {{-- Section 4 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">4</span>
                    Sharing with Third Parties
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    We do not sell or rent your personal data to third parties. We may share limited data with
                    trusted service providers (e.g., e-mail hosting) solely to operate our website, under
                    strict confidentiality agreements. We may also disclose data when required by law.
                </p>
            </div>

            {{-- Section 5 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">5</span>
                    Cookies
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1rem;">
                    Our website uses cookies to remember your language preference and to keep your session active
                    while you navigate the dealer portal. We do not use advertising or tracking cookies.
                    You can disable cookies in your browser settings; however, some features (such as the dealer
                    login) may not function correctly without them.
                </p>
            </div>

            {{-- Section 6 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">6</span>
                    Retention
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    We retain personal data only for as long as necessary to fulfil the purpose for which it was
                    collected, or as required by applicable law. Contact form submissions are stored for up to
                    24 months; dealer account data is retained for the duration of the business relationship
                    and thereafter as required by tax and commercial regulations.
                </p>
            </div>

            {{-- Section 7 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">7</span>
                    Your Rights
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1rem;">
                    Depending on your jurisdiction you may have the right to:
                </p>
                <ul style="color:#4b5563; line-height:1.9; padding-left:1.25rem; display:flex; flex-direction:column; gap:.4rem;">
                    <li>Access the personal data we hold about you.</li>
                    <li>Request correction of inaccurate or incomplete data.</li>
                    <li>Request erasure of your data (subject to legal obligations).</li>
                    <li>Object to or restrict certain processing activities.</li>
                    <li>Withdraw consent at any time (where processing is based on consent).</li>
                </ul>
                <p style="color:#4b5563; line-height:1.8; margin-top:1rem;">
                    To exercise any of these rights, please contact us at the address below.
                </p>
            </div>

            {{-- Section 8 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">8</span>
                    Contact
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1.25rem;">
                    If you have any questions about this Privacy Policy or wish to exercise your rights,
                    please contact us:
                </p>
                <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:1rem; padding:1.5rem 2rem; display:inline-block;">
                    <p style="margin:0; color:#374151; line-height:1.9;">
                        <strong style="color:#0a1f0e;">Keysol Agro</strong><br>
                        E-mail: <a href="mailto:info@keysolagro.com" style="color:#16a34a; text-decoration:none;">info@keysolagro.com</a><br>
                        Website: <a href="{{ config('app.url') }}" style="color:#16a34a; text-decoration:none;">{{ config('app.url') }}</a>
                    </p>
                </div>
            </div>

            {{-- Section 9 --}}
            <div style="padding-top:2rem; border-top:1px solid #e5e7eb;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">9</span>
                    Updates to This Policy
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    We may update this Privacy Policy from time to time. Material changes will be announced
                    on this page with a revised "Last updated" date. We encourage you to review this page
                    periodically.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ─────────────────────────────────────────────
     CTA
───────────────────────────────────────────── --}}
<section style="background:#f9fafb; border-top:1px solid #e5e7eb; padding:60px 0;">
    <div class="container mx-auto px-6" style="text-align:center;">
        <p style="color:#6b7280; font-size:.95rem; margin-bottom:1.5rem;">
            Have a question about how we handle your data?
        </p>
        <a href="{{ lroute('contact') }}"
           style="display:inline-flex; align-items:center; gap:.6rem; background:#16a34a; color:#fff;
                  font-weight:700; padding:.9rem 2rem; border-radius:.75rem; text-decoration:none;
                  transition:background .2s;"
           onmouseover="this.style.background='#15803d'"
           onmouseout="this.style.background='#16a34a'">
            Contact Us
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

@endsection
