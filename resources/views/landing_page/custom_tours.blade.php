@extends('layouts.template')

@section('title', 'Custom tours - Birdtour Asia')

@section('content')
    <!-- Meeta Hero Slider for Custom Tours (Matching Reference custom-slider) -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Custom Tours Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Vogelkop Bird-of-paradise -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e821abb177d95ae356c759e_Vogelkop%20Bird-of-paradise.avif"
                        alt="Vogelkop Bird-of-paradise">
                </div>
                <!-- Slide 2: Painted Tiger Parrot -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8ac962ab1cf8ac7ea8d5c1_Painted%20Tiger%20Parrot.avif"
                        alt="Painted Tiger Parrot">
                </div>
                <!-- Slide 3: Yellow-eyed Pigeon -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e897b584fbaea57dc200816_Yellow-eyed%20Pigeon%20(40).avif"
                        alt="Yellow-eyed Pigeon">
                </div>
                <!-- Slide 4: Beautiful Nuthatch -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e88864ecce5fb81e3a8c636_Nuthatch_Beautiful%20104.avif"
                        alt="Beautiful Nuthatch">
                </div>
                <!-- Slide 5: Lapland Longspur -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e86ced086c3b0ec93ebe3d9_Longspur_Lapland%207.avif"
                        alt="Lapland Longspur">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1"
                    style="font-size: 11px; letter-spacing: 0.5px;">Tailormade Itineraries</span>
            </div>
            <h4>Custom Tours</h4>
            <p>
                Tailormade, custom-designed birding tours available throughout the continent for individuals and private
                groups.
            </p>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Section Header -->
                    <div class="section-title text-center mb-4">
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">Custom Tours</h2>
                        <div class="mx-auto mt-2"
                            style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>

                    <!-- Intro Paragraph -->
                    <div class="lead text-secondary mb-4" style="font-size: 16.5px; line-height: 1.8;">
                        <p>
                            In addition to our scheduled tours, we also offer custom-designed birding tours for groups or
                            individuals. We have extensive experience throughout South Asia, Southeast Asia, North and East
                            Asia, Philippines, New Guinea and Indonesia, and we can organise and guide tours to all areas
                            covered by our scheduled tours and most other destinations in the region.
                        </p>
                    </div>

                    <!-- Custom Tours Looking for Participants Card -->
                    <div class="p-4 rounded-3 border border-success-subtle shadow-sm my-4"
                        style="background-color: #f7faf8; border-left: 5px solid #087d50 !important;">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-success fs-2 mt-1">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-2" style="color: #172b40; font-size: 20px;">Custom tours looking for participants</h4>
                                <p class="mb-0 text-muted" style="font-size: 15px;">
                                    <strong>At the moment there are no custom tours looking for additional
                                        participants.</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Map Section -->
                    <div class="my-5">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold" style="color: #172b40; font-size: 22px;">Explore Our Destinations</h4>
                            <p class="text-secondary" style="font-size: 15px;">
                                <strong>Please click on the pins on the interactive map to get a flavour of each region and
                                    country and what is possible for us to organise for your tailormade tour.</strong>
                            </p>
                        </div>

                        <!-- Google My Maps Embed with Meeta Card Frame -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4"
                            style="border: 1px solid #e2ece0 !important;">
                            <div class="ratio ratio-16x9" style="min-height: 550px;">
                                <iframe src="https://www.google.com/maps/d/embed?mid=10uk_1wHhHBosIlnUn81u8kgeqUI"
                                    title="Birdtour Asia Custom Tours Interactive Map" style="border: 0;" allowfullscreen=""
                                    loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Advantages of Custom Tours -->
                    <div class="my-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4"
                            style="background-color: #ffffff; border: 1px solid #e9f0e8 !important;">
                            <h3 class="fw-bold mb-3" style="color: #172b40; font-size: 24px;">Advantages of a Custom Tour
                            </h3>
                            <p class="text-secondary mb-4" style="font-size: 16px; line-height: 1.8;">
                                Custom tours have many advantages over our main tours; they are inherently more flexible,
                                with group sizes and ground arrangements organised to your specific requirements. They are
                                ideal for those who prefer to travel alone or with small groups of friends, birders with
                                inflexible holidays that do not coincide with our scheduled tour dates or those with
                                specific target species, which may be difficult to see on our main tours. We can also
                                organise custom extensions to any of our scheduled tours.
                            </p>
                            <p class="text-secondary mb-0" style="font-size: 16px; line-height: 1.8;">
                                If you would like to add extra time to one of these tours, please contact us with your plans
                                and we will gladly offer information and advice to help you organise an itinerary which
                                meets your requirements.
                            </p>
                        </div>

                        <!-- Feature Highlights Grid -->
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm p-4 rounded-3 text-center"
                                    style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                                    <div class="text-success mb-3 fs-2">
                                        <i class="fas fa-sliders-h"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #172b40; font-size: 17px;">Total Flexibility</h5>
                                    <p class="text-muted small mb-0">Group sizes, dates, and pace organized around your
                                        timetable.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm p-4 rounded-3 text-center"
                                    style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                                    <div class="text-success mb-3 fs-2">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #172b40; font-size: 17px;">Solo or Private</h5>
                                    <p class="text-muted small mb-0">Travel alone, with family, or with a small circle of
                                        birding friends.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm p-4 rounded-3 text-center"
                                    style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                                    <div class="text-success mb-3 fs-2">
                                        <i class="fas fa-bullseye"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #172b40; font-size: 17px;">Target Species</h5>
                                    <p class="text-muted small mb-0">Focus on the localized, rare endemics you want most.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm p-4 rounded-3 text-center"
                                    style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                                    <div class="text-success mb-3 fs-2">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #172b40; font-size: 17px;">Tour Extensions</h5>
                                    <p class="text-muted small mb-0">Seamlessly extend before or after our scheduled tours.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catch-Up Tours Section -->
                    <div class="my-5 p-4 p-md-5 rounded-4 shadow-sm"
                        style="background: linear-gradient(135deg, #f4f8f5 0%, #eaf4ed 100%); border-left: 6px solid #087d50;">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success text-white px-2 py-1 small text-uppercase">Shared
                                        Costs</span>
                                </div>
                                <h3 class="fw-bold mb-3" style="color: #172b40; font-size: 26px;">Catch-up tours</h3>
                                <p class="text-secondary mb-3" style="font-size: 15.5px; line-height: 1.8;">
                                    Many participants ask us about the possibility of creating itineraries to plug-in the
                                    missing gaps, either due to species missed on previous tours, or because new sites and
                                    species have become available since they visited certain areas. We encourage people to
                                    contact us with their specific requests and we will advertise on this page to help link
                                    you with like-minded birders.
                                </p>
                                <p class="text-secondary mb-0" style="font-size: 15.5px; line-height: 1.8;">
                                    Custom tours are often comparable in cost to our scheduled departures and therefore
                                    offer fantastic value for money. For more information on our popular custom tour
                                    service, please contact us via e-mail or telephone to speak directly to one of our
                                    experienced leaders about your plans.
                                </p>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <a href="mailto:info@birdtourasia.com?subject=Custom%20Tour%20Enquiry"
                                    class="btn btn-primary px-4 py-0 fw-bold rounded-pill w-100 text-center mb-2">
                                    <i class="fas fa-envelope me-2"></i> Contact via Email
                                </a>
                                <a href="tel:+60142234220"
                                    class="btn btn-outline-success px-4 py-0 fw-bold rounded-pill w-100 text-center">
                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp Support
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
