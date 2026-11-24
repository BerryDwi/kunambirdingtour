@extends('layouts.template')

@section('title', $settings['meta_title_tour_reports'] ?? 'Tour Reports - Kunam Birding Tours')
@section('meta_description', $settings['meta_description_tour_reports'] ?? 'Read recent Kunam Birding Tours tour reports with trip highlights, species lists, and field dispatches from across Asia.')

@section('content')
    <!-- Meeta Hero Slider for Tour Reports -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Tour Reports Hero Slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide meeta-hero-slide">
                        <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Floating Announcement Overlay (per-page settings) -->
        @include('landing_page.partials.hero_overlay', ['page' => 'reports'])
    </div>
    <!-- Hero Slider End -->

    <!-- Tour Reports Grid Section -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-title text-center mb-4">
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">Tour Reports</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>

                    <div class="lead text-secondary text-center mb-5" style="font-size: 16.5px; line-height: 1.8;">
                        <p class="mb-2">
                            We have over <strong>200 tour reports</strong> from throughout Asia; as far west as Iran, to the very northeast of Asia - Hokkaido in Japan and southeast to the Papuan side of New Guinea.
                        </p>
                        <p class="text-muted small">
                            Click on any region below to view comprehensive checklists, trip summaries, and downloadable PDF reports.
                        </p>
                    </div>

                    <!-- 20 Report Destinations Grid -->
                    <div class="row g-4">
                        @foreach ($categories as $category)
                            <div class="col-lg-4 col-md-6">
                                <a href="{{ $category->report_url }}" target="_blank" rel="noopener" class="bta-report-card">
                                    <div class="card-img-wrap">
                                        <img src="{{ $category->coverImageUrl() }}" alt="{{ $category->title }}" loading="lazy">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">{{ $category->title }}</h5>
                                        <p class="text-muted small mb-0">{{ $category->summary }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Callout Info Box -->
                    <div class="p-4 p-md-5 rounded-4 shadow-sm my-5 text-center" style="background: linear-gradient(135deg, #f7faf8 0%, #eef5ec 100%); border: 1px solid #dce8d8;">
                        <h4 class="fw-bold mb-2" style="color: #172b40;">Looking for older reports or specific checklists?</h4>
                        <p class="text-secondary mb-4 mx-auto" style="max-width: 650px; font-size: 15px;">
                            We maintain full trip records, photographic logs, and systematic bird lists since 2005. Feel free to contact our team for advice or specialized trip archives.
                        </p>
                        <a href="mailto:{{ $settings['contact_email'] ?? 'info@birdtourasia.com' }}?subject=Tour%20Reports%20Enquiry" class="btn btn-primary px-4 py-2 fw-bold">
                            <i class="fas fa-envelope me-2"></i> Request Specific Report
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
