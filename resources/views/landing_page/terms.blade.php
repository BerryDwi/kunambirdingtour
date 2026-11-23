@extends('layouts.template')

@section('title', $settings['meta_title_terms'] ?? 'Terms and Conditions - Kunam Birding Tours')
@section('meta_description', $settings['meta_description_terms'] ?? 'Kunam Birding Tours booking terms and conditions, including payments, cancellations, insurance, and travel arrangements.')

@push('styles')
<style>
    .terms-sidebar {
        position: sticky;
        top: 100px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        padding: 24px;
    }

    .terms-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .terms-nav-list li {
        margin-bottom: 8px;
    }

    .terms-nav-list a {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .terms-nav-list a:hover {
        color: #087d50;
        background-color: #f0fdf4;
        padding-left: 16px;
    }

    .terms-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 32px;
        margin-bottom: 28px;
        scroll-margin-top: 110px;
        transition: border-color 0.25s ease;
    }

    .terms-card:hover {
        border-color: #087d50;
    }

    .terms-badge-step {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: #f0fdf4;
        color: #087d50;
        font-weight: 700;
        font-size: 14px;
        margin-right: 12px;
    }

    .terms-card h3 {
        color: #172b40;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .terms-card p {
        color: #4b5563;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 14px;
    }

    .terms-highlight-box {
        background-color: #f8fafc;
        border-left: 4px solid #087d50;
        padding: 18px 22px;
        border-radius: 8px;
        margin: 18px 0;
    }

    .cancellation-table th {
        background-color: #172b40;
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
    }

    .cancellation-table td {
        font-size: 14.5px;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
    <!-- Meeta Hero Slider for Terms Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Kunam Birding Tours Terms Slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide meeta-hero-slide">
                        <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Legal &amp; Policy</span>
                <span class="text-white-50 small">Booking Conditions</span>
            </div>
            <h4>Terms and Conditions</h4>
            <p>
                Transparent contractual policies, small-group operational standards, and 100% financial insolvency protection under UK &amp; EU Package Travel Regulations.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="#financial-security" class="btn btn-sm btn-primary py-1 px-3">Financial Security &darr;</a>
                <a href="#payment" class="btn btn-sm btn-outline-light py-1 px-3">Payment Terms</a>
                <a href="#cancellations" class="btn btn-sm btn-outline-light py-1 px-3">Cancellations</a>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <!-- Left Column: Navigation Sidebar (Desktop) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="terms-sidebar">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <i class="fas fa-file-contract text-success fs-5"></i>
                            <h5 class="fw-bold mb-0 text-dark">Quick Navigation</h5>
                        </div>
                        <ul class="terms-nav-list">
                            @foreach ($sections as $section)
                                <li><a href="#{{ $section->anchorId() }}">{{ $section->number }}. {{ $section->navTitle() }}</a></li>
                            @endforeach
                        </ul>

                        <!-- Download Policy Sheet Card -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="p-3 rounded-3 bg-light border">
                                <span class="badge bg-success mb-2">Insolvency Insurance</span>
                                <h6 class="fw-bold mb-1" style="font-size: 14px;">IPP TOFI Certificate (PDF)</h6>
                                <p class="text-muted small mb-3">Download the official International Passenger Protection summary policy sheet.</p>
                                <a href="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/69100ebdffdd7ff9f2ed2846_Birdtour%20Asia%20Limited%20-%20IPP%20TOFI%20PS%20UK%201%202025.pdf" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm w-100 fw-bold">
                                    <i class="fas fa-file-pdf me-1"></i> Download PDF Policy
                                </a>
                            </div>
                        </div>

                        <!-- Direct Help Box -->
                        <div class="mt-3 p-3 rounded-3 bg-success-subtle text-success border border-success-subtle">
                            <strong class="d-block mb-1"><i class="fab fa-whatsapp me-1"></i> Questions on Booking?</strong>
                            <span class="small d-block text-secondary mb-2">Our tour leaders are happy to answer any questions regarding terms or physical pace.</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_primary_number'] ?? '60142234220') }}" target="_blank" class="fw-bold text-success text-decoration-none small">&rarr; WhatsApp Us ({{ $settings['whatsapp_primary_number'] ?? '+60142234220' }})</a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Full Terms Content -->
                <div class="col-lg-8">

                    <!-- Intro Box -->
                    <div class="terms-card border-success" style="background-color: #f7faf8;">
                        <h2 class="main-title fw-bold mb-3" style="color: #172b40; font-size: 30px;">{{ $settings['company_name'] ?? 'Birdtour Asia Limited' }} Terms &amp; Conditions</h2>
                        <p class="lead text-secondary mb-0" style="font-size: 16px;">
                            Please read these Booking Conditions carefully. They outline the basis of your contract with <strong>{{ $settings['company_name'] ?? 'Birdtour Asia Limited' }}</strong> (Company Registration No. {{ $settings['company_registration'] ?? '6383052' }} in England and Wales). When you submit a booking form and pay a deposit, you agree to be bound by all clauses below.
                        </p>
                    </div>

                    @foreach ($sections as $section)
                        <div id="{{ $section->anchorId() }}" class="terms-card">
                            <h3><span class="terms-badge-step">{{ $section->number }}</span> {{ $section->title }}</h3>
                            {!! $section->body !!}
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- ==============================================
                 CONSUMER PROTECTION & AFFILIATION LOGOS
                 ============================================== -->
            <div class="row justify-content-center align-items-center g-4 mt-5 pt-4 border-top">
                <div class="col-6 col-md-3 text-center">
                    <a href="https://www.osme.org" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85acdd25acedd02f22a479_OSME.avif" alt="OSME" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <a href="https://www.orientalbirdclub.org" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85acdcfc819766cdaf60c0_OBC_corporate_logo.avif" alt="OBC" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <a href="https://aa.swarovskioptik.com/birding" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85b028c7184277cedee23c_Swarovski.avif" alt="Swarovski Optik" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <a href="https://www.ipplondon.co.uk" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6539b216589de91ed3511754_198699541d5c923c8508bd343e94a066_IPP.avif" alt="IPP London" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
