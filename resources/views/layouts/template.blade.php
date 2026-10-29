<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Birdtour Asia: birding tours throughout the continent')</title>
    <meta name="description" content="Specialists in Asian birding tours, we offer the best in organised and tailor-made tours throughout the continent, from the Middle-east to New Guinea.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/67aa038b3181ad65a9dae03c_favicon.avif">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Archivo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS
    ============================================ -->
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/flaticon.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/aos.css">
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/nice-select.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('meeta') }}/assets/css/style.css">

    <!-- Custom Theme Adjustments for Birdtour Asia -->
    <style>
        .header-logo img {
            max-height: 48px;
            width: auto;
            object-fit: contain;
        }
        .bta-announcement-overlay {
            position: absolute;
            bottom: 30px;
            left: 50px;
            z-index: 10;
            background: rgba(23, 43, 64, 0.85);
            backdrop-filter: blur(4px);
            padding: 20px 28px;
            border-radius: 12px;
            max-width: 580px;
            border-left: 4px solid #087d50;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        }
        .bta-announcement-overlay h4 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .bta-announcement-overlay p {
            color: #e2e8f0;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }
        .meeta-hero-slide {
            height: 580px;
            position: relative;
        }
        .meeta-hero-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bta-report-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid #edf2f7;
            height: 100%;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }
        .bta-report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(8, 125, 80, 0.15);
            color: inherit;
        }
        .bta-report-card .card-img-wrap {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        .bta-report-card .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .bta-report-card:hover .card-img-wrap img {
            transform: scale(1.08);
        }
        .bta-report-card .card-body {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .bta-badge-status {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .bta-badge-full {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .bta-badge-available {
            background-color: #dcfce7;
            color: #15803d;
        }
        .bta-badge-provisional {
            background-color: #fef3c7;
            color: #b45309;
        }
        @media (max-width: 768px) {
            .bta-announcement-overlay {
                left: 15px;
                right: 15px;
                bottom: 15px;
                padding: 14px 18px;
            }
            .meeta-hero-slide {
                height: 380px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        <!-- Preloader start -->
        <div id="preloader">
            <div class="preloader">
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- Preloader End -->

        <!-- Header Start -->
        <div class="meeta-header-section">
            <div class="header-middle header-sticky">
                <div class="container-fluid custom-container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-4">
                            <!-- Header Logo Start -->
                            <div class="header-logo">
                                <a href="{{ route('home') }}">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8c523028289f697f322d6e_Birdtour-Asia-CMYK-logo.png" alt="Birdtour Asia">
                                </a>
                            </div>
                            <!-- Header Logo End -->
                        </div>
                        <div class="col-lg-7 d-none d-lg-block">
                            <!-- Header Navigation Start -->
                            <div class="header-navigation">
                                <ul class="main-menu">
                                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                        <a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="{{ request()->routeIs('tours') ? 'active' : '' }}">
                                        <a href="{{ route('tours') }}">Tours</a>
                                    </li>
                                    <li class="{{ request()->routeIs('custom-tours') ? 'active' : '' }}">
                                        <a href="{{ route('custom-tours') }}">Custom Tours</a>
                                    </li>
                                    <li class="{{ request()->routeIs('tour-reports') ? 'active' : '' }}">
                                        <a href="{{ route('tour-reports') }}">Reports</a>
                                    </li>
                                    <li class="{{ request()->routeIs('leaders') ? 'active' : '' }}">
                                        <a href="{{ route('leaders') }}">Leaders</a>
                                    </li>
                                    <li class="{{ request()->routeIs('booking*') ? 'active' : '' }}">
                                        <a href="{{ route('booking') }}">Booking</a>
                                    </li>
                                    <li class="{{ request()->routeIs('contact*') ? 'active' : '' }}">
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>
                                    <li class="{{ request()->routeIs('terms*') ? 'active' : '' }}">
                                        <a href="{{ route('terms') }}">Terms</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-8 d-flex justify-content-end align-items-center">
                            <a href="{{ route('custom-tours') }}" class="btn btn-primary d-none d-sm-inline-block py-2 px-3 fs-6">Custom Tour</a>
                            <button class="mobile-menu-toggle d-lg-none ms-2" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"
                                aria-label="Buka menu navigasi">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->

        <!-- Offcanvas Mobile Start -->
        <div class="offcanvas offcanvas-start" id="offcanvasExample">
            <div class="offcanvas-header">
                <div class="offcanvas-logo">
                    <a href="{{ route('home') }}">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8c523028289f697f322d6e_Birdtour-Asia-CMYK-logo.png" alt="Birdtour Asia">
                    </a>
                </div>
                <button type="button" class="close-btn" data-bs-dismiss="offcanvas"><i class="flaticon-close"></i></button>
            </div>
            <div class="offcanvas-body">
                <div class="offcanvas-menu">
                    <ul class="main-menu">
                        <li class="{{ request()->routeIs('home') ? 'active-menu' : '' }}">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('tours') ? 'active-menu' : '' }}">
                            <a href="{{ route('tours') }}">Tours</a>
                        </li>
                        <li class="{{ request()->routeIs('custom-tours') ? 'active-menu' : '' }}">
                            <a href="{{ route('custom-tours') }}">Custom Tours</a>
                        </li>
                        <li class="{{ request()->routeIs('tour-reports') ? 'active-menu' : '' }}">
                            <a href="{{ route('tour-reports') }}">Reports</a>
                        </li>
                        <li class="{{ request()->routeIs('leaders') ? 'active-menu' : '' }}">
                            <a href="{{ route('leaders') }}">Leaders</a>
                        </li>
                        <li class="{{ request()->routeIs('booking*') ? 'active-menu' : '' }}">
                            <a href="{{ route('booking') }}">Booking</a>
                        </li>
                        <li class="{{ request()->routeIs('contact*') ? 'active-menu' : '' }}">
                            <a href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="{{ request()->routeIs('terms*') ? 'active-menu' : '' }}">
                            <a href="{{ route('terms') }}">Terms</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Offcanvas Mobile End -->

        <!-- Main Content Area -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Meeta Footer Start -->
    <div class="meeta-footer-section" style="background-image: url('{{ asset('meeta/assets/images/bg/footer-bg.jpg') }}');">
        <!-- Footer Widget Start -->
        <div class="footer-widget text-center py-5">
            <div class="container">
                <!-- Sponsor Logos Row -->
                <div class="row justify-content-center align-items-center g-4 mb-5 pb-3">
                    <div class="col-6 col-md-3">
                        <a href="https://www.osme.org" target="_blank" rel="noopener">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85acdd25acedd02f22a479_OSME.avif" alt="OSME" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 44px;">
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="https://www.orientalbirdclub.org" target="_blank" rel="noopener">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85acdcfc819766cdaf60c0_OBC_corporate_logo.avif" alt="OBC" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 44px;">
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="https://aa.swarovskioptik.com/birding" target="_blank" rel="noopener">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85b028c7184277cedee23c_Swarovski.avif" alt="Swarovski Optik" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 44px;">
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="https://www.ipplondon.co.uk" target="_blank" rel="noopener">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6539b216589de91ed3511754_198699541d5c923c8508bd343e94a066_IPP.avif" alt="IPP London" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 44px;">
                        </a>
                    </div>
                </div>

                <div class="row text-start text-white g-4 mb-5">
                    <div class="col-lg-4 col-md-6">
                        <h5 class="fw-bold text-white mb-3 text-uppercase">Birdtour Asia Limited</h5>
                        <p class="text-white-50 mb-2">26 Sutton Avenue, Derby, DE73 6RJ, United Kingdom</p>
                        <p class="text-white-50 mb-1">Email: <a href="mailto:info@birdtourasia.com" class="text-white">info@birdtourasia.com</a></p>
                        <p class="text-white-50">WhatsApp: <a href="tel:+60142234220" class="text-white">+60142234220</a> / <a href="tel:+639208316564" class="text-white">+63 920 831 6564</a></p>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h5 class="fw-bold text-white mb-3 text-uppercase">Our Tours</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('tours') }}" class="text-white-50 text-decoration-none hover-white">&rarr; Scheduled tours (2027-2028)</a></li>
                            <li class="mb-2"><a href="{{ route('custom-tours') }}" class="text-white-50 text-decoration-none">&rarr; Tailor-made Custom Tours</a></li>
                            <li class="mb-2"><a href="{{ route('tour-reports') }}" class="text-white-50 text-decoration-none">&rarr; Tour Reports &amp; Species Lists</a></li>
                            <li class="mb-2"><a href="{{ route('booking') }}" class="text-white-50 text-decoration-none">&rarr; Booking &amp; Payment Details</a></li>
                            <li class="mb-2"><a href="{{ route('contact') }}" class="text-white-50 text-decoration-none">&rarr; Contact Us</a></li>
                            <li class="mb-2"><a href="{{ route('terms') }}" class="text-white-50 text-decoration-none">&rarr; Terms &amp; Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <h5 class="fw-bold text-white mb-3 text-uppercase">About &amp; Field Updates</h5>
                        <p class="text-white-50 mb-3">Join us on Facebook for live dispatches, rare bird photos, and trip updates straight from the field.</p>
                        <div class="footer-widget-social justify-content-start">
                            <a href="https://www.facebook.com/birdtourasia" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                            <a href="mailto:info@birdtourasia.com"><i class="fas fa-envelope"></i></a>
                            <a href="tel:+60142234220"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Footer Copyright Start -->
                <div class="footer-copyright border-top border-secondary pt-4">
                    <p class="text-white-50 mb-0">© 2005 - {{ date('Y') }} Birdtour Asia Limited. All Rights Reserved.</p>
                </div>
                <!-- Footer Copyright End -->
            </div>
        </div>
        <!-- Footer Widget End -->
    </div>
    <!-- Meeta Footer End -->

    <!-- Back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Back to top end -->

    <!-- JS ============================================ -->
    <!-- Modernizer & jQuery JS -->
    <script src="{{ asset('meeta') }}/assets/js/vendor/modernizr-3.11.7.min.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/vendor/jquery-1.12.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('meeta') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/bootstrap.min.js"></script>

    <!-- Plugins JS -->
    <script src="{{ asset('meeta') }}/assets/js/swiper-bundle.min.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/all.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/back-to-top.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/waypoints.min.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/aos.js"></script>
    <script src="{{ asset('meeta') }}/assets/js/jquery.nice-select.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('meeta') }}/assets/js/main.js"></script>
    @stack('scripts')
</body>
</html>
