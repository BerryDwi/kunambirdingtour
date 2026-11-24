@extends('layouts.template')

@section('title', $settings['meta_title_leaders'] ?? 'Tour Leaders - Kunam Birding Tours')
@section('meta_description', $settings['meta_description_leaders'] ?? 'Meet the experienced Kunam Birding Tours tour leaders who guide our scheduled and custom birding tours across Asia.')

@section('content')
    <!-- Meeta Hero Slider for Leaders -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Tour Leaders Hero Slider">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide meeta-hero-slide">
                        <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Floating Announcement Overlay (per-page settings) -->
        @include('landing_page.partials.hero_overlay', ['page' => 'leaders'])
    </div>
    <!-- Hero Slider End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Section Header -->
                    <div class="section-title text-center mb-4">
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">Our Leaders</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>

                    <!-- Intro Paragraph -->
                    <div class="lead text-secondary mb-5" style="font-size: 16.5px; line-height: 1.8;">
                        <p class="mb-3">
                            Our leaders are a mix of Asian-based and Asian nationals, whom lead both our scheduled and custom tours. On top of the broad range of scheduled tours offered, we offer a range of custom tours, whether it be extensions to the advertised scheduled tours, but also stand-alone tours. Using Kunam Birding Tours in-house expertise we can tailor the custom tours to suit your requirements.
                        </p>
                        <p class="mb-0">
                            We use a number of locally-based guides for this, and are actively encouraging and promoting the use of young, keen guides throughout the region. Some of our most popular guides are below, though we also have several other guides who lead custom, private tours with us.
                        </p>
                    </div>

                    <!-- Leaders List -->
                    <div class="d-flex flex-column gap-4">

                        @foreach ($leaders as $leader)
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-3 text-center p-4">
                                        <img src="{{ $leader->photoUrl() }}" alt="{{ $leader->name }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                    </div>
                                    <div class="col-md-9 p-4">
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                            <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">{{ $leader->name }}</h4>
                                            <span class="badge {{ $leader->badgeClass() }} fw-bold px-3 py-1">{{ $leader->region }}</span>
                                        </div>
                                        @foreach (preg_split('/\r\n\r\n|\n\n/', (string) $leader->bio) as $paragraph)
                                            <p class="text-secondary {{ $loop->last ? 'mb-0' : 'mb-2' }}" style="font-size: 14.5px; line-height: 1.7;">
                                                {!! $paragraph !!}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Call to Action Box -->
                    <div class="p-4 p-md-5 rounded-4 shadow-sm my-5 text-center" style="background: linear-gradient(135deg, #f7faf8 0%, #eef5ec 100%); border: 1px solid #dce8d8;">
                        <h4 class="fw-bold mb-2" style="color: #172b40;">Plan a Tour with Our Expert Leaders</h4>
                        <p class="text-secondary mb-4 mx-auto" style="max-width: 650px; font-size: 15px;">
                            Whether joining a scheduled small-group tour or organizing a tailor-made private itinerary, our knowledgeable guides are ready to offer advice and guide your journey.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('tours') }}" class="btn btn-primary px-4 py-2 fw-bold">View Scheduled Tours</a>
                            <a href="{{ route('custom-tours') }}" class="btn btn-outline-success px-4 py-2 fw-bold">Plan a Custom Tour</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
