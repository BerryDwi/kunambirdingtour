@extends('layouts.template')

@section('title', 'Tour Reports - Birdtour Asia')

@section('content')
    <!-- Meeta Hero Slider for Tour Reports -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Tour Reports Hero Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Kamchatka Leaf Warbler -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8188735836db6bfcc1c994_Kamchatka%20Leaf%20Warbler.avif" alt="Kamchatka Leaf Warbler">
                </div>
                <!-- Slide 2: Tufted Puffin -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81924d957e0a0d1834103a_Tufted%20Puffin.avif" alt="Tufted Puffin">
                </div>
                <!-- Slide 3: Pied Harrier -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e88b96158eddea5f46f8d54_Harrier_Pied%201.avif" alt="Pied Harrier">
                </div>
                <!-- Slide 4: Long-billed Wren-Babbler -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e88865ecce5fbca75a8c736_Wren%20Babbler_Long-billed%2011.avif" alt="Long-billed Wren-Babbler">
                </div>
                <!-- Slide 5: Sand Lark -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e88b962ab1cf870309e6230_Lark_Sand%202.avif" alt="Sand Lark">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Trip Archives</span>
            </div>
            <h4>Tour Reports</h4>
            <p>
                Click below for latest, or specific country reports. Downloadable PDF reports and species checklists from 2005 to date.
            </p>
        </div>
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
                        <!-- 1. Latest reports -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/latestreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e820b921fde7d7d67fa83af_Lark_Black.avif" alt="Latest reports" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Latest reports</h5>
                                    <p class="text-muted small mb-0">Covering all reports from past 12 months</p>
                                </div>
                            </a>
                        </div>

                        <!-- 2. Borneo -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/borneoreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8188459d7551843dcf4500_Blue-headed%20Pitta.avif" alt="Borneo" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Borneo</h5>
                                    <p class="text-muted small mb-0">Sabah, Sarawak and Kalimantan</p>
                                </div>
                            </a>
                        </div>

                        <!-- 3. Cambodia & Laos -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/cambodiareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e82035e7ebfdf6a94b98179_Mekong%20Wagtail.avif" alt="Cambodia & Laos" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Cambodia &amp; Laos</h5>
                                    <p class="text-muted small mb-0">Covering both Cambodia and Laos</p>
                                </div>
                            </a>
                        </div>

                        <!-- 4. Central Asia -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/turkestanreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e82fbcb9c4559c8f028987d_Ground-jay_Pander%27s%202.avif" alt="Central Asia" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Central Asia</h5>
                                    <p class="text-muted small mb-0">Kazakstan, Tajikistan and Uzbekistan</p>
                                </div>
                            </a>
                        </div>

                        <!-- 5. China -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/chinareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81ca2e5836db021cc3183c_Pheasant_Reeves%27s.avif" alt="China" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">China</h5>
                                    <p class="text-muted small mb-0">Xinjiang to Hainan, through to Tibet</p>
                                </div>
                            </a>
                        </div>

                        <!-- 6. Indian subcontinent -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/indiareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e7cad606c5cf0508effc029_Ward%27s%20Trogon.avif" alt="Indian subcontinent" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Indian subcontinent</h5>
                                    <p class="text-muted small mb-0">India, Bangladesh, Pakistan, Nepal &amp; Bhutan</p>
                                </div>
                            </a>
                        </div>

                        <!-- 7. Indonesia - east -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/wallaceareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81ca3089fbd74a14188c18_Ground%20Dove_Wetar.avif" alt="Indonesia - east" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Indonesia - east</h5>
                                    <p class="text-muted small mb-0">Moluccas, Lesser Sundas, Sulawesi and Banda Sea</p>
                                </div>
                            </a>
                        </div>

                        <!-- 8. Indonesia - west -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/greatersundasreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81a793dad44d1710312ba1_Pitta_Javan%20Banded.avif" alt="Indonesia - west" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Indonesia - west</h5>
                                    <p class="text-muted small mb-0">Sumatra, Java, Bali and Kalimantan</p>
                                </div>
                            </a>
                        </div>

                        <!-- 9. Indonesia - Papua -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/papuareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e821aba8938a12b63ed2361_Wilson%27s%20BOP.avif" alt="Indonesia - Papua" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Indonesia - Papua</h5>
                                    <p class="text-muted small mb-0">Western half of New Guinea</p>
                                </div>
                            </a>
                        </div>

                        <!-- 10. Japan -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/japanreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81887629502f883ebe1dbf_Lanceolated%20Warbler.avif" alt="Japan" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Japan</h5>
                                    <p class="text-muted small mb-0">Both summer and winter</p>
                                </div>
                            </a>
                        </div>

                        <!-- 11. Malaysia -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/malaysiareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81ca2f957e0afe053547b6_Rail-babbler.avif" alt="Malaysia" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Malaysia</h5>
                                    <p class="text-muted small mb-0">Peninsular Malaysia only. For Sabah &amp; Sarawak, see Borneo</p>
                                </div>
                            </a>
                        </div>

                        <!-- 12. Middle East -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/middleastreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/625a6235f1fd036fb219c027_Asir%20Magpie.avif" alt="Middle East" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Middle East</h5>
                                    <p class="text-muted small mb-0">Iran, Saudi Arabia, Socotra</p>
                                </div>
                            </a>
                        </div>

                        <!-- 13. Mongolia -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/mongoliareports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81ca799d75514e69d0825c_Bushchat_Hodgson%27s.avif" alt="Mongolia" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Mongolia</h5>
                                    <p class="text-muted small mb-0">Spectacular birds in the land of no fences</p>
                                </div>
                            </a>
                        </div>

                        <!-- 14. Myanmar -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/myanmar-reports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8179805836db962fc19282_Nuthatch_White-browed-9.avif" alt="Myanmar" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Myanmar</h5>
                                    <p class="text-muted small mb-0">Including a report in search of Gurney's Pitta</p>
                                </div>
                            </a>
                        </div>

                        <!-- 15. Philippines -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/philippinesreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81ca2fdc5445aadaf8763b_Pitta_Whiskered.avif" alt="Philippines" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Philippines</h5>
                                    <p class="text-muted small mb-0">Including scheduled, custom and remote tours</p>
                                </div>
                            </a>
                        </div>

                        <!-- 16. Thailand -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/thailandreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5f2ce3b49c554ee3bb96734f_Siamese%20Fireback.avif" alt="Thailand" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Thailand</h5>
                                    <p class="text-muted small mb-0">Solely custom tours</p>
                                </div>
                            </a>
                        </div>

                        <!-- 17. Timor Leste -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/timorlestereports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81feaeae87b81665ed2e8a_Timor%20Coucal.avif" alt="Timor Leste" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Timor Leste</h5>
                                    <p class="text-muted small mb-0">A solitary report in search of its specialities</p>
                                </div>
                            </a>
                        </div>

                        <!-- 18. Vietnam -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/vietnamreports" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81d48d6e9ef015df0902d2_Pitta_Bar-bellied.avif" alt="Vietnam" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Vietnam</h5>
                                    <p class="text-muted small mb-0">Comprehensive tour reports from north to south</p>
                                </div>
                            </a>
                        </div>

                        <!-- 19. Eastern Polynesia -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://drive.google.com/open?id=1Eyq-UcUpPVpNg6OoZk1Rd-bTmaj0_lTq" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8aad57a6b2c128ecabeda7_Lorikeet_Kuhl%27s.avif" alt="Eastern Polynesia" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Eastern Polynesia</h5>
                                    <p class="text-muted small mb-0">Our mammoth 39-day 2019 tour report</p>
                                </div>
                            </a>
                        </div>

                        <!-- 20. Newsletters -->
                        <div class="col-lg-4 col-md-6">
                            <a href="https://www.birdtourasia.com/newsletter" target="_blank" rel="noopener" class="bta-report-card">
                                <div class="card-img-wrap">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/62cd9bd6b8cf054adf66fe09_Screenshot%202022-07-12%20at%2009.01.54.avif" alt="Newsletters" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1" style="color: #172b40; font-size: 17px;">Newsletters</h5>
                                    <p class="text-muted small mb-0">Our annual <em>The Banded Pitta</em></p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Callout Info Box -->
                    <div class="p-4 p-md-5 rounded-4 shadow-sm my-5 text-center" style="background: linear-gradient(135deg, #f7faf8 0%, #eef5ec 100%); border: 1px solid #dce8d8;">
                        <h4 class="fw-bold mb-2" style="color: #172b40;">Looking for older reports or specific checklists?</h4>
                        <p class="text-secondary mb-4 mx-auto" style="max-width: 650px; font-size: 15px;">
                            We maintain full trip records, photographic logs, and systematic bird lists since 2005. Feel free to contact our team for advice or specialized trip archives.
                        </p>
                        <a href="mailto:info@birdtourasia.com?subject=Tour%20Reports%20Enquiry" class="btn btn-primary px-4 py-2 fw-bold">
                            <i class="fas fa-envelope me-2"></i> Request Specific Report
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
