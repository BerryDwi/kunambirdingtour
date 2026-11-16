@extends('layouts.template')

@section('title', $settings['meta_title_booking'] ?? 'Booking with us - Birdtour Asia')
@section('meta_description', $settings['meta_description_booking'] ?? 'Book a Birdtour Asia birding tour online, review reservation policies, and reserve your place with our team.')

@push('styles')
<style>
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
</style>
@endpush

@section('content')
    <!-- Meeta Hero Slider for Booking Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Birdtour Asia Booking Slider">
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
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Reservations &amp; Booking</span>
                <span class="text-white-50 small">2027 &ndash; 2028 Tours</span>
            </div>
            <h4>Booking with Birdtour Asia</h4>
            <p>
                A clear, simple, and transparent booking process for both our scheduled departures and tailor-made custom tours.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="#booking-faq" class="btn btn-sm btn-primary py-1 px-3">Booking FAQs &darr;</a>
                <a href="{{ route('tours') }}" class="btn btn-sm btn-outline-light py-1 px-3">View Tours &rarr;</a>
                <a href="{{ route('contact') }}" class="btn btn-sm btn-outline-light py-1 px-3">Contact Us</a>
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
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 34px;">Booking with Birdtour Asia</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>
                    <p class="lead text-secondary" style="font-size: 16.5px; line-height: 1.8;">
                        Booking with <strong>Birdtour Asia</strong> could not be simpler. Whether you are reserving a seat on one of our strictly limited small-group scheduled tours or collaborating on an exclusive tailor-made custom adventure, contact our team to verify availability and hold your place.
                    </p>
                </div>
            </div>

            <!-- ==============================================
                 FREQUENTLY ASKED QUESTIONS (FAQ)
                 ============================================== -->
            <div class="row justify-content-center my-5" id="booking-faq">
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
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_primary_number'] ?? '60142234220') }}" target="_blank" rel="noopener" class="btn btn-success py-2 px-3 fw-bold">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp ({{ $settings['whatsapp_primary_number'] ?? '+60142234220' }})
                            </a>
                            <a href="mailto:{{ $settings['contact_email'] ?? 'info@birdtourasia.com' }}?subject=Booking%20enquiry" class="btn btn-outline-light py-2 px-3 fw-bold">
                                <i class="fas fa-envelope me-1"></i> Email Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
