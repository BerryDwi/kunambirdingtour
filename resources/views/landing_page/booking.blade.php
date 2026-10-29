@extends('layouts.template')

@section('title', 'Booking with us & Flowchart - Birdtour Asia')

@push('styles')
<style>
    /* Flowchart & Booking Page Styling */
    .booking-flowchart-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .flowchart-step-card {
        position: relative;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .flowchart-step-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(8, 125, 80, 0.12);
        border-color: #087d50;
    }

    .step-number-badge {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #087d50, #0c5639);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        box-shadow: 0 4px 12px rgba(8, 125, 80, 0.3);
        flex-shrink: 0;
    }

    .step-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(8, 125, 80, 0.1);
        color: #087d50;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .nav-flowchart-pills .nav-link {
        border-radius: 30px;
        padding: 12px 28px;
        font-weight: 700;
        font-size: 15px;
        color: #172b40;
        border: 2px solid transparent;
        background: #f1f5f9;
        transition: all 0.25s ease;
    }

    .nav-flowchart-pills .nav-link.active {
        background: #087d50;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(8, 125, 80, 0.25);
    }

    .bank-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .bank-card:hover {
        transform: translateY(-4px);
    }

    .bank-card-header {
        padding: 22px 26px;
        background: linear-gradient(135deg, #172b40, #0f1d2c);
        color: #ffffff;
    }

    .bank-card-body {
        padding: 24px 26px;
    }

    .bank-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 11px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 14.5px;
    }

    .bank-info-item:last-child {
        border-bottom: none;
    }

    .copy-btn {
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }

    .copy-btn:hover {
        background: #087d50;
        color: #ffffff;
        border-color: #087d50;
    }

    /* Form styling */
    .booking-form-box {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.06);
        border: 1px solid #e2ece0;
        overflow: hidden;
    }

    .form-step-indicator {
        display: flex;
        border-bottom: 1px solid #edf2f7;
        background: #f8fafc;
    }

    .step-indicator-item {
        flex: 1;
        text-align: center;
        padding: 16px 10px;
        font-weight: 700;
        font-size: 14px;
        color: #64748b;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
    }

    .step-indicator-item.active {
        color: #087d50;
        border-bottom-color: #087d50;
        background: #ffffff;
    }

    .step-indicator-item.completed {
        color: #172b40;
    }

    .currency-selector-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .currency-selector-card:hover {
        border-color: #087d50;
    }

    .currency-selector-card.selected {
        border-color: #087d50;
        background-color: #f0fdf4;
    }

    .room-selector-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s;
        height: 100%;
    }

    .room-selector-card:hover {
        border-color: #087d50;
    }

    .room-selector-card.selected {
        border-color: #087d50;
        background-color: #f0fdf4;
    }

    .form-control:focus, .form-select:focus {
        border-color: #087d50;
        box-shadow: 0 0 0 0.25rem rgba(8, 125, 80, 0.15);
    }

    /* Accordion FAQ */
    .booking-accordion .accordion-item {
        border: 1px solid #e2e8f0;
        border-radius: 12px !important;
        margin-bottom: 14px;
        overflow: hidden;
    }

    .booking-accordion .accordion-button {
        font-weight: 700;
        color: #172b40;
        background-color: #f8fafc;
        padding: 18px 22px;
        box-shadow: none;
    }

    .booking-accordion .accordion-button:not(.collapsed) {
        color: #087d50;
        background-color: #f0fdf4;
    }

    .toast-copy-notify {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        display: none;
        background: #172b40;
        color: #ffffff;
        padding: 12px 22px;
        border-radius: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        font-size: 14px;
        font-weight: 600;
        border-left: 4px solid #087d50;
    }
</style>
@endpush

@section('content')
    <!-- Meeta Hero Slider for Booking Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Birdtour Asia Booking Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Philippine Eagle -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/666d2a197b96efb3471efbb8_Tragopan_Western_web.avif" alt="Western Tragopan">
                </div>
                <!-- Slide 2: Vogelkop Bird-of-paradise -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e821abb177d95ae356c759e_Vogelkop%20Bird-of-paradise.avif" alt="Vogelkop Bird-of-paradise">
                </div>
                <!-- Slide 3: Painted Tiger Parrot -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8ac962ab1cf8ac7ea8d5c1_Painted%20Tiger%20Parrot.avif" alt="Painted Tiger Parrot">
                </div>
                <!-- Slide 4: Bornean Banded Pitta -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/642aa3eab24aeb54079951a2_Pitta_Bornean%20Banded%202.avif" alt="Bornean Banded Pitta">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Reservations &amp; Booking</span>
                <span class="text-white-50 small">2027 &ndash; 2028 Tours</span>
            </div>
            <h4>Booking with Birdtour Asia</h4>
            <p>
                A clear, simple, and transparent booking process for both our scheduled departures and tailor-made custom tours.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="#flowchart-section" class="btn btn-sm btn-primary py-1 px-3">View Flowchart &darr;</a>
                <a href="#booking-form-section" class="btn btn-sm btn-outline-light py-1 px-3">Booking Form &rarr;</a>
                <a href="#payment-details-section" class="btn btn-sm btn-outline-light py-1 px-3">Bank Details</a>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">

            @if(session('booking_success'))
                <!-- Flash Success Notification -->
                <div class="alert alert-success alert-dismissible fade show p-4 rounded-4 shadow-sm mb-5 border-0" role="alert" style="background-color: #ecfdf5; border-left: 6px solid #087d50 !important;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-success fs-1">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-success mb-1">Booking Inquiry Received!</h4>
                            <p class="text-secondary mb-2" style="font-size: 15px;">
                                Thank you, <strong>{{ session('booking_success')['full_name'] }}</strong>. We have received your booking request for <strong>{{ session('booking_success')['tour_name'] }}</strong>.
                            </p>
                            <div class="badge bg-success px-3 py-2 fs-6 mb-2">
                                Reference Code: <strong>{{ session('booking_success')['reference_code'] }}</strong>
                            </div>
                            <p class="text-muted small mb-0">
                                Our team will verify tour availability and follow up at <strong>{{ session('booking_success')['email'] }}</strong> within 24–48 hours with deposit transfer confirmation details.
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Section Intro -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center">
                    <div class="section-title text-center mb-4">
                        <span class="badge bg-success-subtle text-success text-uppercase fw-bold px-3 py-2 mb-2 rounded-pill">How It Works</span>
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 34px;">Booking Process &amp; Flowchart</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>
                    <p class="lead text-secondary" style="font-size: 16.5px; line-height: 1.8;">
                        Booking with <strong>Birdtour Asia</strong> could not be simpler. Whether you are reserving a seat on one of our strictly limited small-group scheduled tours or collaborating on an exclusive tailor-made custom adventure, follow the intuitive flowchart below.
                    </p>
                </div>
            </div>

            <!-- ==============================================
                 FLOWCHART SECTION
                 ============================================== -->
            <div id="flowchart-section" class="mb-5 pt-3">
                <!-- Flowchart Navigation Tabs -->
                <div class="d-flex justify-content-center mb-4">
                    <ul class="nav nav-pills nav-flowchart-pills" id="flowchartTab" role="tablist">
                        <li class="nav-item me-2" role="presentation">
                            <button class="nav-link active" id="scheduled-tab" data-bs-toggle="pill" data-bs-target="#scheduled-flow" type="button" role="tab" aria-controls="scheduled-flow" aria-selected="true">
                                <i class="fas fa-calendar-check me-2"></i> Scheduled Tours Flowchart
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="custom-tab" data-bs-toggle="pill" data-bs-target="#custom-flow" type="button" role="tab" aria-controls="custom-flow" aria-selected="false">
                                <i class="fas fa-route me-2"></i> Custom Tours Flowchart
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="flowchartTabContent">
                    <!-- Tab 1: Scheduled Tours Flowchart -->
                    <div class="tab-pane fade show active" id="scheduled-flow" role="tabpanel" aria-labelledby="scheduled-tab">
                        <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0;">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1" style="color: #172b40;">Scheduled Tours Booking Lifecycle</h4>
                                <p class="text-muted small">6 clear steps from initial tour selection to departure</p>
                            </div>

                            <!-- Row 1: Steps 1 to 3 -->
                            <div class="row g-4 align-items-stretch mb-4">
                                <!-- Step 1 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">1</div>
                                            <span class="badge bg-light text-secondary border">Step 01</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-compass"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Choose Your Tour</h5>
                                        <p class="text-muted small mb-3">
                                            Explore our scheduled 2027&ndash;2028 tours across Asia. Review itineraries, dates, target birds, and availability status.
                                        </p>
                                        <div class="mt-auto pt-2 border-top border-light">
                                            <span class="text-success small fw-bold"><i class="fas fa-user me-1"></i> Traveler Action</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">2</div>
                                            <span class="badge bg-light text-secondary border">Step 02</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Enquire &amp; Reserve</h5>
                                        <p class="text-muted small mb-3">
                                            Submit our online booking form or email <a href="mailto:info@birdtourasia.com?subject=Booking%20enquiry" class="text-success fw-bold">info@birdtourasia.com</a>. We verify spaces and provisionally hold your place.
                                        </p>
                                        <div class="mt-auto pt-2 border-top border-light">
                                            <span class="text-primary small fw-bold"><i class="fas fa-handshake me-1"></i> Mutual Confirmation</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">3</div>
                                            <span class="badge bg-light text-secondary border">Step 03</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Payment Options Sent</h5>
                                        <p class="text-muted small mb-3">
                                            We forward official payment instructions with direct GBP (&pound;) or USD (&dollar;) bank details. We do <em>not</em> accept credit cards to save you surcharge fees.
                                        </p>
                                        <div class="mt-auto pt-2 border-top border-light">
                                            <span class="text-success small fw-bold"><i class="fas fa-building me-1"></i> Birdtour Asia Action</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Steps 4 to 6 -->
                            <div class="row g-4 align-items-stretch">
                                <!-- Step 4 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">4</div>
                                            <span class="badge bg-light text-secondary border">Step 04</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Fill Booking Form</h5>
                                        <p class="text-muted small mb-3">
                                            Complete the passenger registration: room choice (single supplement vs twin-sharing), passport info, medical/dietary requirements, and contacts.
                                        </p>
                                        <div class="mt-auto pt-2 border-top border-light">
                                            <span class="text-success small fw-bold"><i class="fas fa-pen-nib me-1"></i> Traveler Action</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 5 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">5</div>
                                            <span class="badge bg-light text-secondary border">Step 05</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-money-check-alt"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Deposit Transfer</h5>
                                        <p class="text-muted small mb-3">
                                            Transfer your deposit to our official GBP or USD bank account via direct wire/SWIFT/Faster Payments. Client funds are protected by IPP London.
                                        </p>
                                        <div class="mt-auto pt-2 border-top border-light">
                                            <span class="text-success small fw-bold"><i class="fas fa-shield-alt me-1"></i> Protected Payment</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 6 -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">6</div>
                                            <span class="badge bg-light text-secondary border">Step 06</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-binoculars"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Confirmed &amp; Tour Pack</h5>
                                        <p class="text-muted small mb-3">
                                            Booking is locked in! You receive our comprehensive Pre-Departure Pack (checklist, flight tips, gear guide). Final balance is due 8–12 weeks prior to departure.
                                        </p>
                                        <div class="mt-auto pt-2 border-top border-light">
                                            <span class="badge bg-success-subtle text-success fw-bold"><i class="fas fa-check me-1"></i> Ready for Adventure</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Custom Tours Flowchart -->
                    <div class="tab-pane fade" id="custom-flow" role="tabpanel" aria-labelledby="custom-tab">
                        <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0;">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1" style="color: #172b40;">Custom &amp; Tailor-Made Tours Flowchart</h4>
                                <p class="text-muted small">Collaborative, flexible route planning tailored to your exact target birds, pace, and dates</p>
                            </div>

                            <div class="row g-4 align-items-stretch">
                                <!-- Step C1 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">1</div>
                                            <span class="badge bg-success-subtle text-success border">Initial Concept</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-comment-dots"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Email or WhatsApp Us</h5>
                                        <p class="text-muted small mb-3">
                                            Tell us your dream destinations, target bird species (e.g. Pittas, Birds-of-Paradise, Owls), preferred dates, and group size. WhatsApp: <a href="tel:+60142234220" class="text-success fw-bold">+60142234220</a>.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step C2 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">2</div>
                                            <span class="badge bg-success-subtle text-success border">Design</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-drafting-compass"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Bespoke Route Planning</h5>
                                        <p class="text-muted small mb-3">
                                            We design a custom day-by-day itinerary with you: optimal birding spots, vehicle logistics, internal flights, and best lodge accommodations.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step C3 -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">3</div>
                                            <span class="badge bg-success-subtle text-success border">Pricing</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-calculator"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Transparent Quote</h5>
                                        <p class="text-muted small mb-3">
                                            We provide an itemised, all-inclusive price quotation (GBP or USD) covering guiding, park entrance fees, vehicles, and lodges with zero hidden surcharges.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step C4 -->
                                <div class="col-lg-6 col-md-6">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">4</div>
                                            <span class="badge bg-success-subtle text-success border">Agreement</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-file-signature"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Booking Details &amp; Deposit</h5>
                                        <p class="text-muted small mb-3">
                                            Submit your custom registration form and wire your deposit to our designated bank account. We secure permits and private guides immediately.
                                        </p>
                                    </div>
                                </div>

                                <!-- Step C5 -->
                                <div class="col-lg-6 col-md-12">
                                    <div class="flowchart-step-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="step-number-badge">5</div>
                                            <span class="badge bg-success-subtle text-success border">Departure</span>
                                        </div>
                                        <div class="step-icon-wrap">
                                            <i class="fas fa-plane-departure"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2" style="color: #172b40;">Pre-Tour Briefing &amp; Guiding</h5>
                                        <p class="text-muted small mb-3">
                                            Direct communication with your designated leader before arrival. Balance cleared, airport meetup confirmed, and seamless birding in the field!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 ONLINE BOOKING / INQUIRY FORM WIZARD
                 ============================================== -->
            <div id="booking-form-section" class="mb-5 pt-3">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="booking-form-box">
                            <div class="p-4 bg-dark text-white d-flex flex-wrap justify-content-between align-items-center" style="background: linear-gradient(135deg, #172b40, #087d50) !important;">
                                <div>
                                    <h3 class="fw-bold text-white mb-1">Online Booking &amp; Reservation Form</h3>
                                    <p class="text-white-50 small mb-0">Fill out your tour preferences to request a seat or tailor-made proposal</p>
                                </div>
                                <div class="d-none d-md-block text-end">
                                    <span class="badge bg-white text-dark px-3 py-2 fw-bold"><i class="fas fa-lock text-success me-1"></i> Secure Form</span>
                                </div>
                            </div>

                            <!-- Form Step Progress -->
                            <div class="form-step-indicator" id="formStepIndicator">
                                <div class="step-indicator-item active" data-step="1">
                                    <span class="badge bg-success me-1">1</span> Tour Details
                                </div>
                                <div class="step-indicator-item" data-step="2">
                                    <span class="badge bg-secondary me-1">2</span> Lead Passenger
                                </div>
                                <div class="step-indicator-item" data-step="3">
                                    <span class="badge bg-secondary me-1">3</span> Preferences &amp; Medical
                                </div>
                                <div class="step-indicator-item" data-step="4">
                                    <span class="badge bg-secondary me-1">4</span> Review &amp; Submit
                                </div>
                            </div>

                            <!-- The Form -->
                            <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" class="p-4 p-md-5">
                                @csrf

                                <!-- STEP 1: TOUR SELECTION -->
                                <div class="form-step-content" id="step1">
                                    <h4 class="fw-bold mb-4" style="color: #172b40;">Step 1: Select Your Tour &amp; Currency</h4>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Tour Category <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check flex-fill p-3 border rounded-3 bg-light">
                                                    <input class="form-check-input" type="radio" name="tour_type" id="type_scheduled" value="scheduled" checked>
                                                    <label class="form-check-label fw-bold" for="type_scheduled">
                                                        Scheduled Tour
                                                        <small class="d-block text-muted fw-normal">Join a set departure (max 6&ndash;8 pax)</small>
                                                    </label>
                                                </div>
                                                <div class="form-check flex-fill p-3 border rounded-3 bg-light">
                                                    <input class="form-check-input" type="radio" name="tour_type" id="type_custom" value="custom">
                                                    <label class="form-check-label fw-bold" for="type_custom">
                                                        Custom Tour
                                                        <small class="d-block text-muted fw-normal">Tailor-made private adventure</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tour_name" class="form-label fw-bold">Select Destination / Tour Name <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-lg" id="tour_name" name="tour_name" required>
                                                <option value="" disabled selected>-- Choose a tour or custom destination --</option>
                                                <optgroup label="2027 Scheduled Departures">
                                                    <option value="China in winter (Jan - Mar 2027)">China in winter (Jan - Mar 2027)</option>
                                                    <option value="Central & Southern Vietnam (Jan - Feb 2027)">Central &amp; Southern Vietnam (Jan - Feb 2027)</option>
                                                    <option value="Philippines: Main Islands & Mindanao (Feb - Mar 2027)">Philippines: Main Islands &amp; Mindanao (Feb - Mar 2027)</option>
                                                    <option value="Cambodia: Giant Ibis & Bengal Florican (Mar 2027)">Cambodia: Giant Ibis &amp; Bengal Florican (Mar 2027)</option>
                                                    <option value="Northeast India & Assam (Mar 2027)">Northeast India &amp; Assam (Mar 2027)</option>
                                                    <option value="Borneo: Sabah & Sarawak (Jul - Aug 2027)">Borneo: Sabah &amp; Sarawak (Jul - Aug 2027)</option>
                                                    <option value="Bhutan: Himalayan Specialities (Apr 2027)">Bhutan: Himalayan Specialities (Apr 2027)</option>
                                                    <option value="Sumatra & West Java (Aug 2027)">Sumatra &amp; West Java (Aug 2027)</option>
                                                    <option value="West Papua & Birds-of-Paradise (Aug - Sep 2027)">West Papua &amp; Birds-of-Paradise (Aug - Sep 2027)</option>
                                                    <option value="Sri Lanka: Endemics & Blue Whales (Nov 2027)">Sri Lanka: Endemics &amp; Blue Whales (Nov 2027)</option>
                                                </optgroup>
                                                <optgroup label="2028 Scheduled Departures">
                                                    <option value="Japan Winter Birding & Cranes (Jan - Feb 2028)">Japan Winter Birding &amp; Cranes (Jan - Feb 2028)</option>
                                                    <option value="Halmahera & Sulawesi Cruise (Sep 2028)">Halmahera &amp; Sulawesi Cruise (Sep 2028)</option>
                                                    <option value="Taiwan Endemics Special (Nov 2028)">Taiwan Endemics Special (Nov 2028)</option>
                                                    <option value="Kazakhstan & Central Asia (May 2028)">Kazakhstan &amp; Central Asia (May 2028)</option>
                                                    <option value="Socotra & Oman (Nov 2028)">Socotra &amp; Oman (Nov 2028)</option>
                                                </optgroup>
                                                <optgroup label="Custom / Tailormade">
                                                    <option value="Custom Itinerary - Indonesia">Custom Itinerary - Indonesia</option>
                                                    <option value="Custom Itinerary - Philippines">Custom Itinerary - Philippines</option>
                                                    <option value="Custom Itinerary - New Guinea">Custom Itinerary - New Guinea</option>
                                                    <option value="Custom Itinerary - Other Destination">Custom Itinerary - Other Destination</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Preferred Payment Currency <span class="text-danger">*</span></label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label class="currency-selector-card w-100 d-block selected" id="labelCurrGBP">
                                                        <input type="radio" name="currency" value="GBP" class="d-none" checked onchange="selectCurrency('GBP')">
                                                        <div class="fs-4 fw-bold text-success">&pound; GBP</div>
                                                        <small class="text-muted">British Pounds (UK Bank)</small>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="currency-selector-card w-100 d-block" id="labelCurrUSD">
                                                        <input type="radio" name="currency" value="USD" class="d-none" onchange="selectCurrency('USD')">
                                                        <div class="fs-4 fw-bold text-primary">&dollar; USD</div>
                                                        <small class="text-muted">US Dollars (NatWest Wire)</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Room Preference <span class="text-danger">*</span></label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label class="room-selector-card d-block selected" id="labelRoomTwin">
                                                        <input type="radio" name="room_preference" value="twin_share" class="d-none" checked onchange="selectRoom('twin_share')">
                                                        <div class="fw-bold mb-1"><i class="fas fa-user-friends text-success me-1"></i> Twin Share</div>
                                                        <small class="text-muted d-block">Room sharing with roommate / partner</small>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="room-selector-card d-block" id="labelRoomSingle">
                                                        <input type="radio" name="room_preference" value="single_supplement" class="d-none" onchange="selectRoom('single_supplement')">
                                                        <div class="fw-bold mb-1"><i class="fas fa-bed text-primary me-1"></i> Single Supplement</div>
                                                        <small class="text-muted d-block">Private single room throughout</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="button" class="btn btn-primary px-4 py-2" onclick="goToStep(2)">
                                            Continue to Lead Passenger &rarr;
                                        </button>
                                    </div>
                                </div>

                                <!-- STEP 2: LEAD PASSENGER & CONTACT -->
                                <div class="form-step-content d-none" id="step2">
                                    <h4 class="fw-bold mb-4" style="color: #172b40;">Step 2: Lead Passenger &amp; Contact Details</h4>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="full_name" class="form-label fw-bold">Full Name (as per Passport) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="e.g. Dr. John H. Watson" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="e.g. john.watson@example.com" required>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label for="phone" class="form-label fw-bold">Phone / WhatsApp Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="+44 7123 456789" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="country" class="form-label fw-bold">Country of Residence <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="country" name="country" placeholder="United Kingdom, USA, Australia, etc." required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="participants_count" class="form-label fw-bold">Number of Travelers <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="participants_count" name="participants_count" min="1" max="10" value="1" required>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="goToStep(1)">&larr; Back</button>
                                        <button type="button" class="btn btn-primary px-4 py-2" onclick="goToStep(3)">Continue to Preferences &rarr;</button>
                                    </div>
                                </div>

                                <!-- STEP 3: PREFERENCES & HEALTH -->
                                <div class="form-step-content d-none" id="step3">
                                    <h4 class="fw-bold mb-4" style="color: #172b40;">Step 3: Preferences, Health &amp; Target Birds</h4>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="birding_experience" class="form-label fw-bold">Birding Experience Level</label>
                                            <select class="form-select" id="birding_experience" name="birding_experience">
                                                <option value="Keen birder / enthusiast" selected>Keen birder / enthusiast</option>
                                                <option value="Hardcore world birder / lister">Hardcore world birder / lister</option>
                                                <option value="Photographer & birder">Photographer &amp; birder</option>
                                                <option value="Casual birdwatcher / nature lover">Casual birdwatcher / nature lover</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tour_year" class="form-label fw-bold">Travel Year / Season Window</label>
                                            <input type="text" class="form-control" id="tour_year" name="tour_year" placeholder="e.g. 2027 Season or Flexible">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dietary_medical" class="form-label fw-bold">Dietary Requirements or Medical / Physical Considerations</label>
                                        <textarea class="form-control" id="dietary_medical" name="dietary_medical" rows="3" placeholder="Vegetarian, vegan, gluten-free, allergies, walking restrictions, etc. (leave blank if none)"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="special_notes" class="form-label fw-bold">Specific Bird Targets or Special Requests</label>
                                        <textarea class="form-control" id="special_notes" name="special_notes" rows="3" placeholder="Any specific target species you hope to see, extension wishes, or questions for our tour leaders..."></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="goToStep(2)">&larr; Back</button>
                                        <button type="button" class="btn btn-primary px-4 py-2" onclick="goToStep(4)">Review &amp; Submit &rarr;</button>
                                    </div>
                                </div>

                                <!-- STEP 4: REVIEW & SUBMIT -->
                                <div class="form-step-content d-none" id="step4">
                                    <h4 class="fw-bold mb-4" style="color: #172b40;">Step 4: Review Your Booking Information</h4>

                                    <div class="card bg-light border-0 p-4 rounded-3 mb-4">
                                        <h5 class="fw-bold mb-3" style="color: #087d50;">Booking Summary</h5>
                                        <div class="row g-2 small text-secondary">
                                            <div class="col-sm-6">
                                                <strong>Tour Category:</strong> <span id="rev_category">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Selected Tour:</strong> <span id="rev_tour">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Currency:</strong> <span id="rev_currency">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Room Type:</strong> <span id="rev_room">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Lead Passenger:</strong> <span id="rev_name">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Email:</strong> <span id="rev_email">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Phone:</strong> <span id="rev_phone">-</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Travelers:</strong> <span id="rev_participants">-</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-check p-3 border rounded-3 bg-white mb-4">
                                        <input class="form-check-input ms-0 me-3" type="checkbox" name="terms_accepted" id="terms_accepted" value="1" required>
                                        <label class="form-check-label text-secondary small" for="terms_accepted">
                                            I understand that submission of this form registers my booking reservation with Birdtour Asia Limited. I acknowledge that tour places are subject to space confirmation, and deposits are settled via direct bank transfer (GBP or USD). I agree to Birdtour Asia's <a href="https://www.birdtourasia.com/terms" target="_blank" class="text-success fw-bold">Booking Terms &amp; Conditions</a>.
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="goToStep(3)">&larr; Back</button>
                                        <button type="submit" id="submitBookingBtn" class="btn btn-success px-5 py-2 fw-bold">
                                            <i class="fas fa-paper-plane me-2"></i> Submit Booking Reservation
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 BANK PAYMENT DETAILS & PDF DOWNLOADS
                 ============================================== -->
            <div id="payment-details-section" class="mb-5 pt-4">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-10 text-center">
                        <span class="badge bg-primary-subtle text-primary text-uppercase fw-bold px-3 py-2 mb-2 rounded-pill">Bank Wire Details</span>
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">Official Bank Payment Sheets</h2>
                        <p class="text-secondary" style="font-size: 16px;">
                            For deposit and final balance payments, we provide dedicated accounts in <strong>British Pounds (GBP &pound;)</strong> and <strong>US Dollars (USD &dollar;)</strong>.
                        </p>
                    </div>
                </div>

                <!-- Payment Notice Callout -->
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-10">
                        <div class="p-4 rounded-3 border shadow-sm" style="background-color: #fffbeb; border-color: #fef3c7 !important; border-left: 5px solid #d97706 !important;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="text-warning fs-3 mt-1">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: #92400e;">Payment Policy Notice: Bank Transfer Only</h5>
                                    <p class="mb-0 text-muted" style="font-size: 14.5px;">
                                        <strong>Please note that we do not accept Credit or Debit card payments.</strong> This enables us to protect our guests from burdensome 3&ndash;5% merchant surcharges and guarantees secure, verified funds transfer straight from your financial institution.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2 Bank Columns: GBP and USD -->
                <div class="row justify-content-center g-4">
                    <!-- GBP Bank Card -->
                    <div class="col-lg-5 col-md-6">
                        <div class="bank-card">
                            <div class="bank-card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success mb-1">UK &amp; Global Accounts</span>
                                    <h4 class="text-white fw-bold mb-0">&pound; GBP Bank Details</h4>
                                    <small class="text-white-50">British Pounds Sterling</small>
                                </div>
                                <div class="fs-1 text-white opacity-25">
                                    <i class="fas fa-pound-sign"></i>
                                </div>
                            </div>
                            <div class="bank-card-body">
                                <div class="bank-info-item">
                                    <span class="text-muted">Account Name:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="gbp_name">Birdtour Asia Limited</strong>
                                        <button class="copy-btn" onclick="copyText('gbp_name')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Bank Name:</span>
                                    <span class="fw-bold">NatWest Bank Plc</span>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Sort Code:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="gbp_sort">60-06-33</strong>
                                        <button class="copy-btn" onclick="copyText('gbp_sort')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Account Number:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="gbp_acc">48920114</strong>
                                        <button class="copy-btn" onclick="copyText('gbp_acc')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">IBAN:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="font-monospace small fw-bold" id="gbp_iban">GB17 NWBK 6006 3348 9201 14</span>
                                        <button class="copy-btn" onclick="copyText('gbp_iban')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">BIC / SWIFT:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="gbp_bic">NWBK GB 2L</strong>
                                        <button class="copy-btn" onclick="copyText('gbp_bic')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top text-center">
                                    <a href="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66c2dec4fb85b8aa220c4cc7_Birdtour%20Asia%20Limited%20bank%20details%20GBP.pdf" target="_blank" rel="noopener" class="btn btn-outline-success w-100 py-2 fw-bold">
                                        <i class="fas fa-file-pdf me-2"></i> Download Official GBP Payment Sheet (PDF)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- USD Bank Card -->
                    <div class="col-lg-5 col-md-6">
                        <div class="bank-card">
                            <div class="bank-card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0e304f, #087d50) !important;">
                                <div>
                                    <span class="badge bg-primary mb-1">International Wire</span>
                                    <h4 class="text-white fw-bold mb-0">&dollar; USD Bank Details</h4>
                                    <small class="text-white-50">United States Dollars</small>
                                </div>
                                <div class="fs-1 text-white opacity-25">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="bank-card-body">
                                <div class="bank-info-item">
                                    <span class="text-muted">Account Name:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="usd_name">Birdtour Asia Limited</strong>
                                        <button class="copy-btn" onclick="copyText('usd_name')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Bank Name:</span>
                                    <span class="fw-bold">NatWest Bank Plc</span>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Currency:</span>
                                    <strong class="text-primary">USD ($)</strong>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Account Number:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="usd_acc">140-0-03094892</strong>
                                        <button class="copy-btn" onclick="copyText('usd_acc')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">SWIFT / BIC:</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong id="usd_bic">NWBK GB 2L</strong>
                                        <button class="copy-btn" onclick="copyText('usd_bic')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="bank-info-item">
                                    <span class="text-muted">Bank Country:</span>
                                    <span class="fw-bold">United Kingdom</span>
                                </div>

                                <div class="mt-4 pt-3 border-top text-center">
                                    <a href="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66c2dec488add2c72f8fa83a_Birdtour%20Asia%20Limited%20bank%20details%20USD.pdf" target="_blank" rel="noopener" class="btn btn-outline-primary w-100 py-2 fw-bold">
                                        <i class="fas fa-file-pdf me-2"></i> Download Official USD Payment Sheet (PDF)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 CONSUMER PROTECTION & AFFILIATIONS
                 ============================================== -->
            <div class="row justify-content-center my-5">
                <div class="col-lg-10">
                    <div class="p-4 p-md-5 rounded-4 shadow-sm bg-light border">
                        <div class="row align-items-center g-4">
                            <div class="col-md-3 text-center">
                                <a href="https://www.ipplondon.co.uk" target="_blank" rel="noopener">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6539b216589de91ed3511754_198699541d5c923c8508bd343e94a066_IPP.avif" alt="IPP London" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 56px;">
                                </a>
                            </div>
                            <div class="col-md-9">
                                <h5 class="fw-bold mb-1" style="color: #172b40;">Financial Consumer Protection (IPP London)</h5>
                                <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                    In accordance with the Passenger and Package Travel Regulations, all guest deposits and prepayments held by <strong>Birdtour Asia Limited</strong> are safeguarded by <em>International Passenger Protection (IPP) London</em>. Your booking investment is 100% financially secured from the day of initial deposit until the completion of your tour.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 FREQUENTLY ASKED QUESTIONS (FAQ)
                 ============================================== -->
            <div class="row justify-content-center my-5">
                <div class="col-lg-10">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold" style="color: #172b40;">Booking FAQs</h3>
                        <p class="text-muted small">Everything you need to know about our reservation policy</p>
                    </div>

                    <div class="accordion booking-accordion" id="bookingFaq">
                        <!-- FAQ 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHead1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCol1" aria-expanded="true" aria-controls="faqCol1">
                                    How much is the deposit and when is it required?
                                </button>
                            </h2>
                            <div id="faqCol1" class="accordion-collapse collapse show" aria-labelledby="faqHead1" data-bs-parent="#bookingFaq">
                                <div class="accordion-body text-secondary small" style="line-height: 1.7;">
                                    Deposits are typically &pound;500 / $700 per person depending on the specific tour and destination logistics. Once we confirm tour space availability, your place is held provisionally for 10 days to allow time for your wire transfer to clear.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHead2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCol2" aria-expanded="false" aria-controls="faqCol2">
                                    Can I pay in US Dollars if I am outside the UK?
                                </button>
                            </h2>
                            <div id="faqCol2" class="accordion-collapse collapse" aria-labelledby="faqHead2" data-bs-parent="#bookingFaq">
                                <div class="accordion-body text-secondary small" style="line-height: 1.7;">
                                    Yes, absolutely. We maintain accounts in both <strong>British Pounds (GBP)</strong> and <strong>US Dollars (USD)</strong>. Simply select your preferred currency on our booking sheet to receive matching wire instructions without incurring exchange conversion penalties.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHead3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCol3" aria-expanded="false" aria-controls="faqCol3">
                                    What if I travel alone? Must I pay the single supplement?
                                </button>
                            </h2>
                            <div id="faqCol3" class="accordion-collapse collapse" aria-labelledby="faqHead3" data-bs-parent="#bookingFaq">
                                <div class="accordion-body text-secondary small" style="line-height: 1.7;">
                                    If you travel solo and prefer to twin-share with another guest of the same gender to avoid the single supplement, please let us know. If a roommate is found, no single supplement is charged. If no roommate is available, the standard single supplement applies.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHead4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCol4" aria-expanded="false" aria-controls="faqCol4">
                                    When is the final balance payment due?
                                </button>
                            </h2>
                            <div id="faqCol4" class="accordion-collapse collapse" aria-labelledby="faqHead4" data-bs-parent="#bookingFaq">
                                <div class="accordion-body text-secondary small" style="line-height: 1.7;">
                                    The final tour balance is typically due 8 to 12 weeks prior to departure. We send a formal reminder invoice along with updated arrival details and pre-trip guidance well in advance.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 INSTANT CONTACT & WHATSAPP BAR
                 ============================================== -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="p-4 rounded-4 text-white d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: linear-gradient(135deg, #0c5639, #172b40);">
                        <div>
                            <h4 class="fw-bold text-white mb-1">Need help or prefer to book via WhatsApp?</h4>
                            <p class="text-white-50 small mb-0">Our tour leaders are ready to assist with itineraries, flights, and dates.</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://wa.me/60142234220" target="_blank" rel="noopener" class="btn btn-success py-2 px-3 fw-bold">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp (+60142234220)
                            </a>
                            <a href="mailto:info@birdtourasia.com?subject=Booking%20enquiry" class="btn btn-outline-light py-2 px-3 fw-bold">
                                <i class="fas fa-envelope me-1"></i> Email Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Copy to Clipboard Toast -->
    <div id="copyToast" class="toast-copy-notify">
        <i class="fas fa-check-circle text-success me-2"></i> Copied to clipboard!
    </div>
@endsection

@push('scripts')
<script>
    // Tab switching for currency
    function selectCurrency(curr) {
        document.getElementById('labelCurrGBP').classList.toggle('selected', curr === 'GBP');
        document.getElementById('labelCurrUSD').classList.toggle('selected', curr === 'USD');
    }

    // Room preference
    function selectRoom(room) {
        document.getElementById('labelRoomTwin').classList.toggle('selected', room === 'twin_share');
        document.getElementById('labelRoomSingle').classList.toggle('selected', room === 'single_supplement');
    }

    // Multi-step form logic
    function goToStep(step) {
        // Validation check before proceeding
        if (step > 1) {
            const tourSelect = document.getElementById('tour_name');
            if (!tourSelect.value) {
                alert('Please select a tour or custom destination first.');
                tourSelect.focus();
                return;
            }
        }
        if (step > 2) {
            const name = document.getElementById('full_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const country = document.getElementById('country').value.trim();

            if (!name || !email || !phone || !country) {
                alert('Please fill out all required contact fields.');
                return;
            }
        }

        // Hide all steps
        for (let i = 1; i <= 4; i++) {
            const el = document.getElementById('step' + i);
            if (el) el.classList.add('d-none');
        }

        // Show target step
        const targetStep = document.getElementById('step' + step);
        if (targetStep) {
            targetStep.classList.remove('d-none');
        }

        // Update indicators
        const indicators = document.querySelectorAll('#formStepIndicator .step-indicator-item');
        indicators.forEach((item, idx) => {
            const sNum = idx + 1;
            item.classList.remove('active', 'completed');
            if (sNum === step) {
                item.classList.add('active');
            } else if (sNum < step) {
                item.classList.add('completed');
            }
        });

        // Fill review summary if step 4
        if (step === 4) {
            const isCustom = document.getElementById('type_custom').checked;
            document.getElementById('rev_category').textContent = isCustom ? 'Custom / Tailormade Tour' : 'Scheduled Small-Group Tour';
            document.getElementById('rev_tour').textContent = document.getElementById('tour_name').value || 'Not selected';
            const currVal = document.querySelector('input[name="currency"]:checked');
            document.getElementById('rev_currency').textContent = currVal ? currVal.value : 'GBP';
            const roomVal = document.querySelector('input[name="room_preference"]:checked');
            document.getElementById('rev_room').textContent = (roomVal && roomVal.value === 'single_supplement') ? 'Single Supplement' : 'Twin Share';
            document.getElementById('rev_name').textContent = document.getElementById('full_name').value;
            document.getElementById('rev_email').textContent = document.getElementById('email').value;
            document.getElementById('rev_phone').textContent = document.getElementById('phone').value;
            document.getElementById('rev_participants').textContent = document.getElementById('participants_count').value + ' traveler(s)';
        }

        // Smooth scroll to form
        const formBox = document.getElementById('booking-form-section');
        if (formBox) {
            formBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Copy to clipboard helper
    function copyText(elementId) {
        const textEl = document.getElementById(elementId);
        if (!textEl) return;
        const text = textEl.textContent.trim();

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(showToast);
        } else {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                showToast();
            } catch (err) {
                console.error('Fallback copy error', err);
            }
            document.body.removeChild(textarea);
        }
    }

    function showToast() {
        const toast = document.getElementById('copyToast');
        if (!toast) return;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 2200);
    }
</script>
@endpush
