@extends('layouts.template')

@section('title', $settings['meta_title_tours'] ?? 'Scheduled Tours Calendar - Birdtour Asia')
@section('meta_description', $settings['meta_description_tours'] ?? 'Browse Birdtour Asia scheduled birding tours for 2027 and 2028, with small groups and expert leaders across Asia.')

@section('content')
    <!-- Meeta Page Banner -->
    <div class="section page-banner-section" style="background-image: url('{{ $hero?->imageUrl() ?? 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6828344570093a50ccb5faa6_Plover_Oriental.avif' }}'); background-size: cover; background-position: center;">
        <div class="shape-2"></div>
        <div class="container">
            <div class="page-banner-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-banner text-center">
                            <h2 class="title">{{ $hero?->title ?? 'Scheduled Tours' }}</h2>
                            <p class="text-white-50 mt-2">{{ $hero?->text ?? '2027 - 2028 Scheduled Tour Calendar' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Banner End -->

    <!-- Tours Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <!-- Intro Paragraphs -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <p class="lead text-secondary mb-3" style="font-size: 16.5px; line-height: 1.7;">
                        We are running the following scheduled tours during <strong>2027 - 2028</strong>. Please click on any of the tours for further details including a full itinerary. Our 2029 tours will begin to appear from December 2027.
                    </p>

                    <div class="alert alert-light border border-success-subtle shadow-sm p-3 rounded-3 mb-3" style="border-left: 4px solid #087d50 !important; background-color: #f7faf8;">
                        <p class="mb-0 text-muted" style="font-size: 14px;">
                            <strong>Please note:</strong> Tours marked <em>'Tour provisionally full'</em> are for a tour that is fully booked but since the tour cost is yet to be announced no deposits have yet been paid, so please do notify us of your interest in case a place becomes available once the tour cost is confirmed.
                        </p>
                    </div>

                    <p class="text-secondary mb-4" style="font-size: 15px;">
                        <strong>Catch-up tours:</strong> In addition to our scheduled tours, we also offer 'Catch-up tours', whereby birders are looking for additional participants to make up a team for select species or a specific itinerary. Please visit our <a href="{{ route('custom-tours') }}" class="text-success fw-bold text-decoration-none">Custom tours</a> page for further details.
                    </p>

                    @if ($calendarGroups->isNotEmpty() || $futureTours->isNotEmpty())
                        <!-- Year Jump Navigation Buttons -->
                        <div class="d-flex justify-content-center gap-3 my-4">
                            @foreach ($calendarGroups as $year => $yearTours)
                                <a href="#{{ $year }}-tours" class="btn btn-outline-primary px-4 py-2 fw-bold">{{ $year }} tours</a>
                            @endforeach

                            @if ($futureTours->isNotEmpty())
                                <a href="#future-tours" class="btn btn-outline-primary px-4 py-2 fw-bold">Future tours</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @foreach ($calendarGroups as $year => $yearTours)
                        <div id="{{ $year }}-tours" class="mb-5 pt-3">
                            <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-2">
                                <h3 class="fw-bold mb-0" style="color: #172b40;">{{ $year }} Tours</h3>

                                @php($departureCount = $yearTours->count())
                                <span class="badge bg-success">{{ $departureCount }} {{ \Illuminate\Support\Str::plural('Departure', $departureCount) }}</span>
                            </div>

                            @foreach ($yearTours as $tour)
                                @include('landing_page.partials.tour-card', ['tour' => $tour])
                            @endforeach
                        </div>
                    @endforeach

                    @if ($futureTours->isNotEmpty())
                        <div id="future-tours" class="mb-5 pt-3">
                            <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-2">
                                <h3 class="fw-bold mb-0" style="color: #172b40;">Beyond {{ $lastCalendarYear }}</h3>
                            </div>

                            @foreach ($futureTours as $tour)
                                @include('landing_page.partials.tour-card', ['tour' => $tour])
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
