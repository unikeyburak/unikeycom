@extends('layouts.app')

@section('title', 'Terms of Use — Keysol Agro')
@section('meta_description', 'Keysol Agro Terms of Use — the rules and conditions that govern your use of our website and services.')

@section('content')

@include('partials.page-header', [
    'title'    => __('Kullanım Şartları'),
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
                By accessing or using the website located at <strong>{{ config('app.url') }}</strong>
                (the "<strong>Site</strong>"), operated by <strong>Keysol Agro</strong>, you agree to be
                bound by these Terms of Use. If you do not agree to these terms, please do not use the Site.
            </p>

            {{-- Section 1 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">1</span>
                    General Provisions
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    This Site is operated by Keysol Agro and serves as an informational product catalogue
                    for agricultural professionals and authorised dealers. All content, designs, logos and
                    materials on the Site are protected by applicable intellectual property laws.
                </p>
            </div>

            {{-- Section 2 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">2</span>
                    Permitted Use
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1rem;">
                    When using this Site you agree to:
                </p>
                <ul style="color:#4b5563; line-height:1.9; padding-left:1.25rem; display:flex; flex-direction:column; gap:.4rem;">
                    <li>Comply with all applicable laws and regulations.</li>
                    <li>Respect the rights of third parties, including intellectual property rights.</li>
                    <li>Refrain from any action that may compromise the security or integrity of the Site.</li>
                    <li>Provide accurate and truthful information in any form submission.</li>
                    <li>Not disrupt or interfere with the normal operation of the Site or its servers.</li>
                    <li>Not attempt to gain unauthorised access to any part of the Site or its systems.</li>
                </ul>
            </div>

            {{-- Section 3 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">3</span>
                    Intellectual Property
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    All content on this Site — including text, images, videos, logos, graphics and product
                    data — is owned by or licensed to Keysol Agro. You may not copy, reproduce, distribute,
                    modify or create derivative works from any content without our prior written consent.
                    Brief quotations for non-commercial reference are permitted provided the source is credited.
                </p>
            </div>

            {{-- Section 4 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">4</span>
                    Product Information
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    All product descriptions, technical specifications and application guidelines on this
                    Site are provided for informational purposes only. Keysol Agro reserves the right to
                    modify product information at any time without prior notice. Product images are
                    illustrative and actual products may differ. This Site does not constitute an offer
                    for sale; purchasing inquiries should be directed to your authorised regional distributor.
                </p>
            </div>

            {{-- Section 5 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">5</span>
                    Limitation of Liability
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1rem;">
                    To the fullest extent permitted by law, Keysol Agro shall not be liable for:
                </p>
                <ul style="color:#4b5563; line-height:1.9; padding-left:1.25rem; display:flex; flex-direction:column; gap:.4rem;">
                    <li>Any inaccuracies or errors in the content of this Site.</li>
                    <li>Any interruption or unavailability of the Site.</li>
                    <li>Any loss or damage arising from reliance on information published on the Site.</li>
                    <li>Content or practices of third-party websites linked from this Site.</li>
                </ul>
            </div>

            {{-- Section 6 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">6</span>
                    Dealer Portal Accounts
                </h2>
                <p style="color:#4b5563; line-height:1.8; margin-bottom:1rem;">
                    If you register for a dealer portal account, you agree that:
                </p>
                <ul style="color:#4b5563; line-height:1.9; padding-left:1.25rem; display:flex; flex-direction:column; gap:.4rem;">
                    <li>All information provided during registration is accurate and up to date.</li>
                    <li>You are solely responsible for maintaining the security of your login credentials.</li>
                    <li>You will not share your account with or transfer it to any other person.</li>
                    <li>You are responsible for all activities that occur under your account.</li>
                    <li>You will notify us immediately of any unauthorised use of your account.</li>
                </ul>
                <p style="color:#4b5563; line-height:1.8; margin-top:1rem;">
                    Keysol Agro reserves the right to suspend or terminate accounts that violate these Terms.
                </p>
            </div>

            {{-- Section 7 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">7</span>
                    Privacy
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    Your use of this Site is also governed by our
                    <a href="{{ lroute('privacy') }}" style="color:#16a34a; text-decoration:none; font-weight:600;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">Privacy Policy</a>,
                    which is incorporated into these Terms by reference.
                </p>
            </div>

            {{-- Section 8 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">8</span>
                    User Submissions
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    Any comments, suggestions or other content you submit through the Site
                    (e.g., via the contact form) will be treated as non-confidential.
                    By submitting content, you grant Keysol Agro a non-exclusive, royalty-free licence
                    to use, reproduce and publish that content for the purpose of operating and improving
                    our services.
                </p>
            </div>

            {{-- Section 9 --}}
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">9</span>
                    Governing Law
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    These Terms of Use are governed by and construed in accordance with the laws of the
                    Republic of Turkey. Any dispute arising out of or in connection with these Terms shall
                    be subject to the exclusive jurisdiction of the courts of Turkey.
                </p>
            </div>

            {{-- Section 10 --}}
            <div style="padding-top:2rem; border-top:1px solid #e5e7eb;">
                <h2 style="font-size:1.25rem; font-weight:800; color:#0a1f0e; margin-bottom:1rem; display:flex; align-items:center; gap:.75rem;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; background:#f0fdf4; border-radius:.5rem; font-size:.75rem; font-weight:900; color:#16a34a; flex-shrink:0;">10</span>
                    Changes to These Terms
                </h2>
                <p style="color:#4b5563; line-height:1.8;">
                    Keysol Agro reserves the right to update these Terms of Use at any time.
                    Changes will be posted on this page with a revised "Last updated" date.
                    Continued use of the Site after any changes constitutes your acceptance of the
                    new Terms.
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
            Questions about these terms? We're happy to help.
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
