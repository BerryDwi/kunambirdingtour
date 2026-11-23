@extends('layouts.template')

@section('title', $settings['meta_title'] ?? 'Kunam Birding Tours: birding tours throughout the continent')
@section('meta_description', $settings['meta_description'] ?? 'Specialists in Asian birding tours, we offer the best in organised and tailor-made tours throughout the continent, from the Middle-east to New Guinea.')

@section('content')
    <!-- Meeta Hero Slider Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Kunam Birding Tours Hero Slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide meeta-hero-slide">
                        <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Floating Announcement Overlay (Matching Kunam Birding Tours Latest News Banner) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">{{ $settings['home_announcement_badge'] ?? 'Field Update' }}</span>
                <span class="text-white-50 small">{{ $settings['home_announcement_date'] ?? '' }}</span>
            </div>
            <h4>{{ $settings['home_announcement_title'] ?? '' }}</h4>
            <p>
                {{ $settings['home_announcement_body'] ?? '' }}
            </p>
            <div class="mt-3">
                <a href="{{ $settings['home_announcement_cta_url'] ?? route('tours') }}" class="btn btn-sm btn-primary py-1 px-3">{{ $settings['home_announcement_cta_label'] ?? 'View 2027 Departures' }} &rarr;</a>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- About Section Start -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10">
                    <div class="section-title text-center mb-4">
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">{{ $settings['home_about_title'] ?? 'Specialists in Asian Birding Tours' }}</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>

                    <div class="birdtour-about-content lead text-secondary" style="font-size: 16.5px; line-height: 1.8;">
                        @foreach (preg_split('/\r\n\r\n|\n\n/', (string) ($settings['home_about_body'] ?? '')) as $paragraph)
                            <p class="{{ $loop->last ? 'mb-4' : 'mb-3' }}">
                                {{ $paragraph }}
                            </p>
                        @endforeach

                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                            <a href="{{ route('tours') }}" class="btn btn-primary btn-sm px-4 py-2 rounded-pill fw-bold">View Tours</a>
                            <a href="mailto:{{ $settings['contact_email'] ?? 'info@birdtourasia.com' }}?subject=Tour%20enquiry" class="btn btn-outline-primary btn-sm px-4 py-2 rounded-pill fw-bold">Email Us</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_primary_number'] ?? '60142234220') }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm px-4 py-2 rounded-pill fw-bold">WhatsApp</a>
                        </div>
                    </div>

                    <!-- Award / Survey Highlight Box -->
                    <div class="p-4 rounded-3 border border-success-subtle shadow-sm my-4" style="background-color: #f7faf8; border-left: 5px solid #087d50 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-success fs-1">
                                <i class="fas fa-award"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #172b40;">{{ $settings['home_award_title'] ?? '100% Survey Score & Top Ranked Operator' }}</h5>
                                <p class="mb-0 text-muted" style="font-size: 14.5px; line-height: 1.6;">
                                    {{ $settings['home_award_text'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

    <!-- Latest News From Field (Facebook Dispatch) -->
    <div class="py-4" style="background-color: #f4f8f5; border-top: 1px solid #e2ece0; border-bottom: 1px solid #e2ece0;">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-primary fs-2">
                            <i class="fab fa-facebook-square"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color: #172b40;">{{ $settings['home_facebook_title'] ?? 'Latest news from the field' }}</h5>
                            <p class="mb-0 text-secondary" style="font-size: 14.5px;">
                                {{ $settings['home_facebook_text'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ $settings['facebook_url'] ?? 'https://www.facebook.com/birdtourasia' }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm px-4 py-2 rounded-pill fw-bold">
                        <i class="fab fa-facebook-f me-2"></i> {{ $settings['facebook_button_label'] ?? 'Visit Facebook Page' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Selected Latest Tour Reports Grid -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="main-title fw-bold" style="color: #172b40; font-size: 30px;">{{ $settings['home_reports_title'] ?? 'Selected Latest Tour Reports' }}</h2>
                <p class="text-muted mt-2">{{ $settings['home_reports_subtitle'] ?? '' }}</p>
                <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
            </div>

            <div class="row g-4">
                @foreach ($latestReports as $report)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ $report->report_url }}" target="_blank" rel="noopener" class="bta-report-card">
                            <div class="card-img-wrap">
                                <img src="{{ $report->coverImageUrl() }}" alt="{{ $report->title }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">{{ $report->title }}</h5>
                                <span class="text-muted small">{{ $report->summary }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if ($product)
        <!-- Leech Socks Product Section -->
        <div class="section-padding" style="background-color: #f7faf8; border-top: 1px solid #eef2ec;">
            <div class="container">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-success-subtle text-success fw-bold px-3 py-1" style="font-size: 12px;">FIELD GEAR</span>
                            </div>
                            <h3 class="fw-bold mb-3" style="color: #172b40; font-size: 26px;">{{ $product->name }}</h3>
                            <p class="text-secondary mb-3" style="font-size: 15.5px; line-height: 1.7;">
                                {{ \Illuminate\Support\Str::of($product->description)->before("\n\n") }}
                            </p>
                            <p class="text-secondary mb-4" style="font-size: 15.5px;">
                                Available in two sizes: <strong>Small (&lt;40 / UK6)</strong> and <strong>Large (40-45 / UK7-11)</strong>, at only <strong>£18 / $22</strong> per pair including VAT and worldwide postage.
                            </p>
                            <a href="{{ $product->purchase_url }}" target="_blank" rel="noopener" class="btn btn-primary px-4 py-2">
                                Full Details On Field Gear Page &rarr;
                            </a>
                        </div>
                        <div class="col-lg-5 text-center">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="img-fluid rounded-3 shadow" style="max-height: 300px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
