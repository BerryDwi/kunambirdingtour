@extends('layouts.template')

@section('title', 'Contact us - Birdtour Asia')

@push('styles')
    <style>
        .contact-info-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(8, 125, 80, 0.12);
            border-color: #087d50;
        }

        .contact-icon-circle {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .contact-card-form {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2ece0;
            overflow: hidden;
        }

        .contact-field-notice {
            background-color: #f7faf8;
            border-left: 4px solid #087d50;
            padding: 16px 20px;
            border-radius: 8px;
        }

        .whatsapp-leader-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            transition: all 0.2s;
        }

        .whatsapp-leader-card:hover {
            background: #f0fdf4;
            border-color: #22c55e;
        }
    </style>
@endpush

@section('content')
    <!-- Meeta Hero Slider for Contact Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Birdtour Asia Contact Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Oriental Plover -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6828344570093a50ccb5faa6_Plover_Oriental.avif"
                        alt="Oriental Plover">
                </div>
                <!-- Slide 2: Painted Tiger Parrot -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8ac962ab1cf8ac7ea8d5c1_Painted%20Tiger%20Parrot.avif"
                        alt="Painted Tiger Parrot">
                </div>
                <!-- Slide 3: Vogelkop Bird-of-paradise -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e821abb177d95ae356c759e_Vogelkop%20Bird-of-paradise.avif"
                        alt="Vogelkop Bird-of-paradise">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Get
                    In Touch</span>
                <span class="text-white-50 small">Direct Assistance</span>
            </div>
            <h4>Contact Birdtour Asia</h4>
            <p>
                Reach our tour leaders in the field or office manager directly via Email, WhatsApp, or through our contact
                form.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="#contact-channels" class="btn btn-sm btn-primary py-1 px-3">Contact Details &darr;</a>
                <a href="#contact-form-section" class="btn btn-sm btn-outline-light py-1 px-3">Send a Message &rarr;</a>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">

            @if (session('contact_success'))
                <!-- Flash Success Notification -->
                <div class="alert alert-success alert-dismissible fade show p-4 rounded-4 shadow-sm mb-5 border-0"
                    role="alert" style="background-color: #ecfdf5; border-left: 6px solid #087d50 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-success fs-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-success mb-1">Thank you!</h4>
                            <p class="text-secondary mb-0" style="font-size: 15px;">
                                {{ session('contact_success') }}
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Section Intro -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center">
                    <div class="section-title text-center mb-3">
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 34px;">Contact Us</h2>
                        <div class="mx-auto mt-2"
                            style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>
                    <p class="lead text-secondary" style="font-size: 16.5px; line-height: 1.8;">
                        If you would like to find out more about the services offered by <strong>Birdtour Asia</strong>, we
                        can be contacted by email, WhatsApp, Facebook, or through the online inquiry form below.
                    </p>
                </div>
            </div>

            <!-- ==============================================
                     CONTACT CHANNELS ROW
                     ============================================== -->
            <div id="contact-channels" class="row g-4 mb-5 justify-content-center">
                <!-- Card 1: Email Communication -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box">
                        <div class="contact-icon-circle bg-success text-white">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #172b40;">Email Us</h4>
                        <p class="text-muted small mb-3">
                            Direct email inquiries for scheduled tour bookings, tailor-made itineraries, or logistical
                            queries.
                        </p>
                        <div class="mb-3">
                            <span class="d-block small text-muted">General Tour Enquiries:</span>
                            <a href="mailto:info@birdtourasia.com?subject=Tour%20enquiry"
                                class="fw-bold text-success text-decoration-none fs-6">
                                info@birdtourasia.com &rarr;
                            </a>
                        </div>
                        <div class="pt-2 border-top border-light">
                            <span class="d-block small text-muted">Office Manager, Bob:</span>
                            <a href="mailto:office@birdtourasia.com?subject=Tour%20enquiry"
                                class="fw-bold text-dark text-decoration-none small">
                                office@birdtourasia.com &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: WhatsApp Field Contacts -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box">
                        <div class="contact-icon-circle bg-success text-white"
                            style="background-color: #25D366 !important;">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #172b40;">WhatsApp Chat</h4>
                        <p class="text-muted small mb-3">
                            The easiest way to reach us for a quick question or last-minute update, directly in the field.
                        </p>
                        <div class="d-flex flex-column gap-2 mb-2">
                            <div class="whatsapp-leader-card d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="d-block text-dark">James Eaton</strong>
                                    <span class="text-muted small">+60142234220</span>
                                </div>
                                <a href="https://wa.me/60142234220" target="_blank" rel="noopener"
                                    class="btn btn-sm btn-success px-2 py-1">
                                    <i class="fab fa-whatsapp me-1"></i> Chat
                                </a>
                            </div>
                            <div class="whatsapp-leader-card d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="d-block text-dark">Rob Hutchinson</strong>
                                    <span class="text-muted small">+63 920 831 6564</span>
                                </div>
                                <a href="https://wa.me/639208316564" target="_blank" rel="noopener"
                                    class="btn btn-sm btn-success px-2 py-1">
                                    <i class="fab fa-whatsapp me-1"></i> Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Facebook & Office Address -->
                <div class="col-lg-4 col-md-12">
                    <div class="contact-info-box">
                        <div class="contact-icon-circle bg-primary text-white"
                            style="background-color: #1877F2 !important;">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #172b40;">Social &amp; Registered Office</h4>
                        <p class="text-muted small mb-3">
                            Connect on Facebook for latest dispatches, species sightings, and trip albums.
                        </p>
                        <div class="mb-3">
                            <a href="https://www.facebook.com/birdtourasia" target="_blank" rel="noopener"
                                class="btn btn-outline-primary btn-sm w-100 py-2 fw-bold">
                                <i class="fab fa-facebook-square me-2"></i> Visit Facebook Page
                            </a>
                        </div>
                        <div class="pt-2 border-top border-light">
                            <span class="d-block small text-muted">Registered Office:</span>
                            <address class="small text-secondary mb-0" style="line-height: 1.5;">
                                <strong>Birdtour Asia Limited</strong><br>
                                26 Sutton Avenue, Derby, DE73 6RJ<br>
                                United Kingdom
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field Delay Notice Box -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="contact-field-notice shadow-sm">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-success fs-3 mt-1">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #172b40;">A Quick Note Regarding Field
                                    Communications</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.7;">
                                    When messaging us on WhatsApp, we kindly request that you sign off with your full name
                                    so we know who we are replying to. Please note, as our leaders are often in remote
                                    birding reserves and cloud forests across Asia, there could occasionally be a brief
                                    delay if we are out of cellular reception &mdash; otherwise we usually reply promptly!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                     ONLINE CONTACT FORM SECTION
                     ============================================== -->
            <div id="contact-form-section" class="row justify-content-center pt-2">
                <div class="col-lg-10">
                    <div class="contact-card-form">
                        <div class="p-4 p-md-5 bg-dark text-white"
                            style="background: linear-gradient(135deg, #172b40, #087d50) !important;">
                            <h3 class="fw-bold text-white mb-1">Send Us a Message</h3>
                            <p class="text-white-50 small mb-0">Fields marked with an asterisk (<span
                                    class="text-warning">*</span>) are required.</p>
                        </div>

                        <form action="{{ route('contact.send') }}" method="POST" class="p-4 p-md-5">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4 rounded-3">
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label fw-bold">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name" value="{{ old('first_name') }}"
                                        placeholder="Your first name" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label fw-bold">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name') }}"
                                        placeholder="Your last name" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="your.email@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-bold">Phone / WhatsApp Number</label>
                                    <input type="tel"
                                        class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="+1 555 123 4567">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold">Message <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                                    placeholder="Tell us which tours or destinations you are interested in, dates, or any questions..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="p-3 bg-light rounded-3 mb-4 border">
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-shield-alt text-success me-1"></i>
                                    We respect your privacy and never disclose any of your personal information to third
                                    parties, as per our <a href="https://www.birdtourasia.com/privacypolicy"
                                        target="_blank" class="text-success fw-bold text-decoration-none">privacy
                                        policy</a>.
                                </p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small d-none d-sm-inline">We typically reply within 24–48
                                    hours.</span>
                                <button type="submit" class="btn btn-primary px-5 py-3 fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
