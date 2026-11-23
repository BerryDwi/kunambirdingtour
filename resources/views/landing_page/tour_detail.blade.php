@extends('layouts.template')

@section('title', ($tour->meta_title ?: $tour->name) . ' - Kunam Birding Tours')
@section('meta_description', $tour->meta_description ?: ($tour->summary ?: 'Birding tour to ' . ($tour->country ?? 'Asia') . ' with Kunam Birding Tours.'))

@section('content')
    <!-- Page Banner Section -->
    <div class="section page-banner-section" style="background-image: url('{{ $tour->imageUrl() }}'); background-size: cover; background-position: center; position: relative;">
        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(23, 43, 64, 0.5) 0%, rgba(23, 43, 64, 0.9) 100%);"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="page-banner-wrap py-5">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb justify-content-center mb-0" style="font-size: 14px;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tours') }}" class="text-white-50 text-decoration-none">Scheduled Tours</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">{{ $tour->name }}</li>
                            </ol>
                        </nav>
                        <div class="page-banner text-center text-white">
                            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2">
                                @if ($tour->country)
                                    <span class="badge bg-white text-dark fw-bold px-3 py-1">
                                        <i class="fas fa-map-marker-alt text-success me-1"></i> {{ $tour->country }}
                                    </span>
                                @endif
                                <span class="badge bg-success text-uppercase px-3 py-1">{{ $tour->year }} Departure</span>
                                <span class="bta-badge-status {{ $tour->statusBadgeClass() }}">{{ $tour->statusLabel() }}</span>
                            </div>
                            <h2 class="title text-white mb-2">{{ $tour->name }}</h2>
                            <p class="text-white-50 fs-5 mb-0"><i class="far fa-calendar-alt me-2"></i>{{ $tour->date_label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Banner End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <!-- Left Column (Overview, Specs, Itinerary) -->
                <div class="col-lg-8">

                    <!-- Key Specs Card -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                        <div class="row g-3 text-center text-sm-start">
                            <div class="col-sm-6 col-md-3">
                                <div class="text-muted small">Dates</div>
                                <div class="fw-bold text-dark mt-1">{{ $tour->date_label }}</div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="text-muted small">Duration</div>
                                <div class="fw-bold text-dark mt-1">{{ $tour->duration_days ? $tour->duration_days . ' Days' : 'Enquire' }}</div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="text-muted small">Group Size</div>
                                <div class="fw-bold text-dark mt-1">Max {{ $tour->group_size ?: '6–8' }} Birders</div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="text-muted small">Status</div>
                                <div class="mt-1">
                                    <span class="bta-badge-status {{ $tour->statusBadgeClass() }}" style="font-size: 11px;">
                                        {{ $tour->statusLabel() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tour Overview -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5 mb-4" style="background-color: #ffffff; border: 1px solid #e2ece0 !important;">
                        <h3 class="fw-bold mb-3" style="color: #172b40;">Tour Overview</h3>
                        <div class="mx-0 mb-4" style="width: 50px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>

                        @if ($tour->summary)
                            <div class="alert alert-light border border-success-subtle shadow-sm p-3 rounded-3 mb-4" style="border-left: 4px solid #087d50 !important; background-color: #f7faf8;">
                                <p class="mb-0 text-secondary fw-semibold" style="font-size: 15.5px; line-height: 1.6;">
                                    {{ $tour->summary }}
                                </p>
                            </div>
                        @endif

                        @if ($tour->description)
                            <div class="text-secondary" style="font-size: 15.5px; line-height: 1.8;">
                                @foreach (preg_split('/\r\n\r\n|\n\n/', (string) $tour->description) as $paragraph)
                                    <p class="{{ $loop->last ? 'mb-0' : 'mb-3' }}">{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        @else
                            <p class="text-secondary mb-0" style="font-size: 15.5px; line-height: 1.8;">
                                Kunam Birding Tours specializes in Asian birdwatching tours. This {{ $tour->name }} departure offers premier birding opportunities with strictly limited small groups and experienced leaders.
                            </p>
                        @endif
                    </div>

                    <!-- Itinerary Section -->
                    @if ($tour->itinerary)
                        <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5 mb-4" style="background-color: #ffffff; border: 1px solid #e2ece0 !important;">
                            <h3 class="fw-bold mb-3" style="color: #172b40;">Tour Itinerary</h3>
                            <div class="mx-0 mb-4" style="width: 50px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>

                            <div class="d-flex flex-column gap-3">
                                @foreach (preg_split('/\r\n|\n/', (string) $tour->itinerary) as $line)
                                    @if (trim($line) !== '')
                                        <div class="p-3 rounded-3 border" style="background-color: #fafcf9;">
                                            <p class="text-secondary mb-0" style="font-size: 15px; line-height: 1.6;">
                                                {{ $line }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Related Tours -->
                    @if ($relatedTours->isNotEmpty())
                        <div class="mt-5 pt-3">
                            <h4 class="fw-bold mb-3" style="color: #172b40;">Other Departures You Might Like</h4>
                            <div class="mx-0 mb-4" style="width: 40px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>

                            <div class="d-flex flex-column gap-2">
                                @foreach ($relatedTours as $related)
                                    @include('landing_page.partials.tour-card', ['tour' => $related])
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Right Sidebar (Pricing & Booking Action) -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden sticky-top" style="top: 100px; border: 1px solid #e2ece0 !important;">
                        <div class="p-4" style="background: linear-gradient(135deg, #172b40 0%, #087d50 100%); color: #ffffff;">
                            <span class="badge bg-white text-dark mb-2 px-3 py-1 fw-bold" style="font-size: 11px;">TOUR INVESTMENT</span>
                            @if ($tour->price_gbp || $tour->price_usd)
                                <div class="d-flex align-items-baseline gap-2 mb-1">
                                    @if ($tour->price_gbp)
                                        <span class="fs-2 fw-bold">&pound;{{ number_format($tour->price_gbp) }}</span>
                                    @endif
                                    @if ($tour->price_usd)
                                        <span class="fs-5 text-white-50">/ ${{ number_format($tour->price_usd) }}</span>
                                    @endif
                                </div>
                                <span class="text-white-50 small">per person based on twin share</span>
                            @else
                                <h5 class="fw-bold text-white mb-1">Cost To Be Announced</h5>
                                <span class="text-white-50 small">Register your interest to hold a place</span>
                            @endif

                            @if ($tour->single_supplement_gbp || $tour->single_supplement_usd)
                                <div class="mt-2 pt-2 border-top border-white border-opacity-25 text-white-50 small">
                                    Single supplement:
                                    @if ($tour->single_supplement_gbp)
                                        <strong class="text-white">&pound;{{ number_format($tour->single_supplement_gbp) }}</strong>
                                    @endif
                                    @if ($tour->single_supplement_usd)
                                        / <strong class="text-white">${{ number_format($tour->single_supplement_usd) }}</strong>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="p-4 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                <span class="text-muted small">Current Space Status:</span>
                                <span class="bta-badge-status {{ $tour->statusBadgeClass() }}" style="font-size: 11px;">
                                    {{ $tour->statusLabel() }}
                                </span>
                            </div>

                            @php
                                $tourEnquirySubject = rawurlencode('Booking Enquiry: ' . $tour->name . ' (' . $tour->date_label . ')');
                                $whatsappMessage = rawurlencode('Hello Kunam Birding Tours, I am interested in reserving a place on: ' . $tour->name . ' (' . $tour->date_label . '). Please advise on space availability.');
                            @endphp

                            <!-- WhatsApp Inquiry Button -->
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_primary_number'] ?? '60142234220') }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener" class="btn btn-success w-100 py-2 mb-2 fw-bold d-flex align-items-center justify-content-center gap-2">
                                <i class="fab fa-whatsapp fs-5"></i> Enquire via WhatsApp
                            </a>

                            <!-- Email Inquiry Button -->
                            <a href="mailto:{{ $settings['contact_email'] ?? 'info@birdtourasia.com' }}?subject={{ $tourEnquirySubject }}" class="btn btn-primary w-100 py-2 mb-3 fw-bold d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-envelope"></i> Enquire via Email
                            </a>

                            <div class="p-3 rounded-3 bg-light text-secondary small border">
                                <div class="fw-bold text-dark mb-1"><i class="fas fa-info-circle text-success me-1"></i> How to Reserve</div>
                                Contact us directly with your traveler details. Once availability is confirmed, your space is held provisionally for 10 days while deposit arrangements are made.
                            </div>

                            <div class="mt-3 text-center">
                                <a href="{{ route('tours') }}" class="text-muted small text-decoration-none">
                                    &larr; Back to all Scheduled Tours
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
