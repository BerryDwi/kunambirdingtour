@extends('layouts.template')

@section('title', 'Birdtour Asia: birding tours throughout the continent')

@section('content')
    <!-- Meeta Hero Slider Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Birdtour Asia Hero Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Oriental Plover -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6828344570093a50ccb5faa6_Plover_Oriental.avif" alt="Oriental Plover">
                </div>
                <!-- Slide 2: Western Tragopan -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/666d2a197b96efb3471efbb8_Tragopan_Western_web.avif" alt="Western Tragopan">
                </div>
                <!-- Slide 3: Bornean Banded Pitta -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/642aa3eab24aeb54079951a2_Pitta_Bornean%20Banded%202.avif" alt="Bornean Banded Pitta">
                </div>
                <!-- Slide 4: Red-headed Bunting -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/666949389ab4af61d98dec6a_Bunting_Red-headed%207.avif" alt="Red-headed Bunting">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Matching Birdtour Asia Latest News Banner) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Field Update</span>
                <span class="text-white-50 small">14/10 Announcement</span>
            </div>
            <h4>Latest news 14/10</h4>
            <p>
                <strong>2027:</strong> we have spaces on Laos and Cambodia in March, Lesser Florican &amp; Western Himalaya tour in July and Sulawesi islands Cruise.
            </p>
            <div class="mt-3">
                <a href="{{ route('tours') }}" class="btn btn-sm btn-primary py-1 px-3">View 2027 Departures &rarr;</a>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- About Section Start -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10">
                    <div class="section-title text-center mb-4">
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">Specialists in Asian Birding Tours</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>

                    <div class="birdtour-about-content lead text-secondary" style="font-size: 16.5px; line-height: 1.8;">
                        <p class="mb-3">
                            <strong>Birdtour Asia</strong> are the specialists in birding tours, offering the best in organised and tailor-made custom tours throughout the region for 20 years. We offer you the best possible bird-tour experience through a combination of the most experienced and knowledgeable leaders in the region, small group sizes, a friendly and relaxed atmosphere, and of course some of the finest birding in the world.
                        </p>

                        <p class="mb-3">
                            Our tours cover a huge swathe from Saudi Arabia and Socotra in the west, to the Kamchatka coastline in the north, and as far east as West Papua in New Guinea. We carefully plan each tour to optimise the birding opportunities at each site visited, concentrating on the most enigmatic, localised and hard to find species. By allowing time for comprehensive coverage we will give ourselves the best realistic chance of locating these speciality birds of the region.
                        </p>

                        <p class="mb-3">
                            Our scheduled tours are equalled in popularity by our custom tours, with itineraries designed with the intimate knowledge of our Birdtour Asia team to match your needs for any bird targets, mammals, culture or cuisine.
                        </p>

                        <p class="mb-4">
                            Please visit our <a href="{{ route('tours') }}" class="fw-bold text-success text-decoration-none">tours page</a> for our 2026-2028 scheduled departures or contact us via
                            <a href="mailto:info@birdtourasia.com?subject=Tour%20enquiry" class="fw-bold text-success text-decoration-none">e-mail</a> or
                            <a href="tel:+60142234220" class="fw-bold text-success text-decoration-none">WhatsApp</a> if you would like us to organise one of our popular custom tours. Our 2029 tour calendar will be published in December 2026.
                        </p>
                    </div>

                    <!-- Award / Survey Highlight Box -->
                    <div class="p-4 rounded-3 border border-success-subtle shadow-sm my-4" style="background-color: #f7faf8; border-left: 5px solid #087d50 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-success fs-1">
                                <i class="fas fa-award"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: #172b40;">100% Survey Score &amp; Top Ranked Operator</h5>
                                <p class="mb-0 text-muted" style="font-size: 14.5px; line-height: 1.6;">
                                    We take great pride in the positive feedback and testimonials from our past participants: we were the only tour company to score <strong>100% in every category</strong> in a <em>Birdwatch Magazine</em> survey, as well as placing <strong>number one</strong> by Stride (<a href="https://www.stridetravel.com/" target="_blank" rel="noopener" class="text-success text-decoration-none">www.stridetravel.com</a>) in their Top 10 Birdwatching tour operators.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

    <!-- Latest News From Field (Facebook Dispatch) -->
    <div class="py-4" style="background-color: #f4f8f5; border-top: 1px solid #e2ece0; border-bottom: 1px solid #e2ece0;">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-primary fs-2">
                            <i class="fab fa-facebook-square"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1" style="color: #172b40;">Latest news from the field</h5>
                            <p class="mb-0 text-secondary" style="font-size: 14.5px;">
                                Our <a href="https://www.facebook.com/birdtourasia" target="_blank" rel="noopener" class="text-success fw-bold text-decoration-none">Facebook page</a> has regular updates from the field and tour photo albums, along with instant messaging support.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="https://www.facebook.com/birdtourasia" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm px-4 py-2 rounded-pill fw-bold">
                        <i class="fab fa-facebook-f me-2"></i> Visit Facebook Page
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Selected Latest Tour Reports Grid -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="main-title fw-bold" style="color: #172b40; font-size: 30px;">Selected Latest Tour Reports</h2>
                <p class="text-muted mt-2">Explore recent trip highlights, species lists, and dispatches from across Asia</p>
                <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
            </div>

            <div class="row g-4">
                <!-- 1. Lesser Florican -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btaflorican26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/63058861534d3623290bfb52_Florican_Lesser.avif" alt="Lesser Florican and Western Himalaya" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Lesser Florican &amp; Western Himalaya</h5>
                            <span class="text-muted small">July - August 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 2. Philippines -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btaphilippinesbonanza26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5f50cf2c9ebeb51c96818042_Palawan%20Peacock%20Pheasant_Large.avif" alt="Philippines Endemic Bonanza" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Philippines Endemic Bonanza</h5>
                            <span class="text-muted small">February - March 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 3. Central Asia -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btaturkistan26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/62fa29f8d42bad02037292ab_Plover_Caspian.avif" alt="Central Asia & Caucasus" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Central Asia &amp; Caucasus</h5>
                            <span class="text-muted small">May 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 4. Sumatra and Java -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btasumatra26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/649122e41339581aa2361b10_Sumatran%20Ground%20Cuckoo.avif" alt="Sumatra and Java" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Sumatra and Java</h5>
                            <span class="text-muted small">July - August 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 5. Xinjiang and Tibetan plateau -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btatibet26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e86ee6b69567561926d9f68_Pinktail_Przewalski%27s%2084.avif" alt="Xinjiang and Tibetan plateau" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Xinjiang and Tibetan Plateau</h5>
                            <span class="text-muted small">June - July 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 6. The Banded Pitta 23 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/thebandedpitta23" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6a48b4e44ece1b870dd16870_bandedpitta23.avif" alt="The Banded Pitta 23" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">The Banded Pitta 23</h5>
                            <span class="text-muted small">Summer Newsletter 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 7. Sichuan -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btasichuan26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66d13a8060de3ad3deb00499_Temminck%27s%20Tragopan.avif" alt="Sichuan" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Sichuan</h5>
                            <span class="text-muted small">May - June 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 8. Northeast India -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btaeaglenest26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e7cad606c5cf0508effc029_Ward%27s%20Trogon.avif" alt="Northeast India" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Northeast India</h5>
                            <span class="text-muted small">April - May 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 9. Peninsular Malaysia -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btamalaysia26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e889c52bebe7dcf16fe9468_Plain-pouched%20Hornbill.avif" alt="Peninsular Malaysia" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Peninsular Malaysia</h5>
                            <span class="text-muted small">June - July 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 10. West India -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btawestindia26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/666bdbb4f7f67dffa7ce9cc0_Bullfinch_Orange.avif" alt="West India" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">West India</h5>
                            <span class="text-muted small">January - February 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 11. South India & Andamans -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btaandamans26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8886e8a6b2c149baa0faa3_Thrush_Nilgiri%2018.avif" alt="South India & Andamans" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">South India &amp; Andamans</h5>
                            <span class="text-muted small">January 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 12. Tajikistan and Pakistan -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btatajikistan26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/666bdbb4f7f67dffa7ce9cc0_Bullfinch_Orange.avif" alt="Tajikistan and Pakistan" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Tajikistan and Pakistan</h5>
                            <span class="text-muted small">May - June 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 13. Japan in spring -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btajapan26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5f1ae933e5f8874c2bfd3bd8_96f7f094bba6aad7a4619036313bd9d2_Copper%20Pheasant.avif" alt="Japan in spring" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Japan in Spring</h5>
                            <span class="text-muted small">May - June 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 14. East China -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/eastchina26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81ca2e5836db021cc3183c_Pheasant_Reeves%27s.avif" alt="East China" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">East China</h5>
                            <span class="text-muted small">May 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 15. China in winter -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btachinawinter26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66018305014df47ecaf6f140_Crane_Siberian%203.avif" alt="China in winter" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">China in Winter</h5>
                            <span class="text-muted small">January - February 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 16. Vietnam -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btavietnam26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e81d48d6e9ef015df0902d2_Pitta_Bar-bellied.avif" alt="Vietnam" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Vietnam 2026</h5>
                            <span class="text-muted small">February - March 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 17. Intrepid Philippines -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btaintrepidphilippines26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6868d917369d6171530b3407_Visayan%20Wattled%20Broadbill_Bohol.avif" alt="Intrepid Philippines" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Intrepid Philippines 2026</h5>
                            <span class="text-muted small">March - April 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 18. Japan in winter -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btajapanwinter26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/65ccb01c35cbfaf65f21b5bd_Eagle_Steller%27s%20Sea%203.avif" alt="Japan in winter" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Japan in Winter</h5>
                            <span class="text-muted small">January 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 19. China winter custom - eBird -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://ebird.org/tripreport/480781" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66018305014df47ecaf6f140_Crane_Siberian%203.avif" alt="China winter custom - eBird" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">China Winter Custom - eBird</h5>
                            <span class="text-muted small">February - March 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 20. Bangladesh -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/btabangladesh26" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/699595a915e9b7d6032729e4_finfoot%20female.avif" alt="Bangladesh" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Bangladesh</h5>
                            <span class="text-muted small">January 2026</span>
                        </div>
                    </a>
                </div>

                <!-- 21. Sulawesi islands Cruise -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="https://tinyurl.com/sulawesicruise" target="_blank" rel="noopener" class="bta-report-card">
                        <div class="card-img-wrap">
                            <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/691024f651f562527c0d217a_Myna_Bare-eyed%201.avif" alt="Sulawesi islands Cruise" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold mb-1" style="font-size: 15px; color: #172b40;">Sulawesi Islands Cruise</h5>
                            <span class="text-muted small">October 2025</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Leech Socks Product Section -->
    <div class="section-padding" style="background-color: #f7faf8; border-top: 1px solid #eef2ec;">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success-subtle text-success fw-bold px-3 py-1" style="font-size: 12px;">FIELD GEAR</span>
                        </div>
                        <h3 class="fw-bold mb-3" style="color: #172b40; font-size: 26px;">Leech Socks</h3>
                        <p class="text-secondary mb-3" style="font-size: 15.5px; line-height: 1.7;">
                            Our leech socks are designed and field-tested by birders, for birders. These are no ordinary Leech Socks - using 100% very thin, lightweight cotton, we've specifically designed them for comfort, meaning a flat sole (no stitching down the middle of the sole!), tapered at the ankle to avoid being baggy and hanging over your shoes, and in forest green. Simple and effective.
                        </p>
                        <p class="text-secondary mb-4" style="font-size: 15.5px;">
                            Available in two sizes: <strong>Small (&lt;40 / UK6)</strong> and <strong>Large (40-45 / UK7-11)</strong>, at only <strong>£18 / $22</strong> per pair including VAT and worldwide postage.
                        </p>
                        <a href="https://www.birdtourasia.com/leechsocks" target="_blank" rel="noopener" class="btn btn-primary px-4 py-2">
                            Full Details On Field Gear Page &rarr;
                        </a>
                    </div>
                    <div class="col-lg-5 text-center">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66a4c39855cf7f0134ec13d8_leech%20socks.avif" alt="Leech Socks" class="img-fluid rounded-3 shadow" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
