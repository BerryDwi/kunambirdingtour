@extends('layouts.template')

@section('title', 'Scheduled Tours Calendar - Birdtour Asia')

@section('content')
    <!-- Meeta Page Banner -->
    <div class="section page-banner-section" style="background-image: url('https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6828344570093a50ccb5faa6_Plover_Oriental.avif'); background-size: cover; background-position: center;">
        <div class="shape-2"></div>
        <div class="container">
            <div class="page-banner-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-banner text-center">
                            <h2 class="title">Scheduled Tours</h2>
                            <p class="text-white-50 mt-2">2027 - 2028 Scheduled Tour Calendar</p>
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

                    <!-- Year Jump Navigation Buttons -->
                    <div class="d-flex justify-content-center gap-3 my-4">
                        <a href="#2027-tours" class="btn btn-outline-primary px-4 py-2 fw-bold">2027 tours</a>
                        <a href="#2028-tours" class="btn btn-outline-primary px-4 py-2 fw-bold">2028 tours</a>
                        <a href="#2029-tours" class="btn btn-outline-primary px-4 py-2 fw-bold">Future tours</a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- ==============================================
                         2027 SECTION
                         ============================================== -->
                    <div id="2027-tours" class="mb-5 pt-3">
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-2">
                            <h3 class="fw-bold mb-0" style="color: #172b40;">2027 Tours</h3>
                            <span class="badge bg-success">29 Departures</span>
                        </div>

                        <!-- Tour 1: China in winter -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66018305014df47ecaf6f140_Crane_Siberian%203.avif" alt="China in winter" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/chinawinter2027" target="_blank" rel="noopener" class="text-dark text-decoration-none hover-success">China in winter</a></h5>
                                    <p class="text-muted small mb-1">Covering Beijing to Hainan and across to Yunnan</p>
                                    <div class="text-success small fw-semibold">10th - 29th January 2027 (20 days) / 20th February - 12th March 2027 (20 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full me-1">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 2: Southern India -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8886e7bebe7d67b7fe2021_Owl_Andaman%20Scops.avif" alt="Southern India and Andamans" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/southindia2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Southern India and Andamans</a></h5>
                                    <p class="text-muted small mb-1">Western Ghats and Andaman &amp; Nicobar endemics (can be combined with West India)</p>
                                    <div class="text-success small fw-semibold">10th - 24th January 2027 (15 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 3: West India -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e822da115c85a3ad6f937d2_Green%20Avadavat.avif" alt="West India" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/westindia2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">West India</a></h5>
                                    <p class="text-muted small mb-1">Punjab, Rajasthan, Gujarat and Maharashtra + Orange Bullfinch extension</p>
                                    <div class="text-success small fw-semibold">25th January - 11th / 14th February 2027 (18 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 4: Bangladesh -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/699595a915e9b7d6032729e4_finfoot%20female.avif" alt="Bangladesh" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/bangladesh2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Bangladesh</a></h5>
                                    <p class="text-muted small mb-1">The original Masked Finfoot boat experience</p>
                                    <div class="text-success small fw-semibold">24th January - 1st February 2027 (11 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 5: Japan Classic Winter -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/65ccb01c35cbfaf65f21b5bd_Eagle_Steller%27s%20Sea%203.avif" alt="Japan Winter" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/japan2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Japan: Classic Winter</a></h5>
                                    <p class="text-muted small mb-1">Steller's Sea Eagle, Red-crowned Cranes, Blakiston's Fish Owl</p>
                                    <div class="text-success small fw-semibold">3rd - 18th February 2027 (16 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 6: Cambodia and Laos -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e88538d4fbaeabbf91ab714_Giant%20Ibis%20(2).avif" alt="Cambodia and Laos" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/cambodia2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Cambodia and Laos</a></h5>
                                    <p class="text-muted small mb-1">Critically Endangered specialities + Cambodian Laughingthrush extension</p>
                                    <div class="text-success small fw-semibold">28th February - 10th / 14th March 2027 (11 / 14 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-available">One space available</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 7: Vietnam -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8aba75ab1cf8ac36a888e9_Laughingthrush_Collared%2067.avif" alt="Vietnam" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/vietnam2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Vietnam</a></h5>
                                    <p class="text-muted small mb-1">From south to north, and every bit in-between</p>
                                    <div class="text-success small fw-semibold">21st February - 13th March 2027 (21 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 8: Philippines Endemic Bonanza -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8d337f030ea4e84f57346e_Steere%27s%20Pitta_PICOP%2C%20Philippines_05Feb17_4N3A9885.avif" alt="Philippines" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/philippines2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Philippines: Endemic-bonanza</a></h5>
                                    <p class="text-muted small mb-1">Luzon, Mindanao and Palawan (can be combined with Intrepid Philippines)</p>
                                    <div class="text-success small fw-semibold">28th February - 20th March 2027 (21 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 9: Borneo Sabah & Sarawak -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/642aa3eab24aeb54079951a2_Pitta_Bornean%20Banded%202.avif" alt="Borneo" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/borneo2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Borneo: Sabah &amp; Sarawak</a></h5>
                                    <p class="text-muted small mb-1">Comprehensive tour combining Sabah with Sarawak highlands</p>
                                    <div class="text-success small fw-semibold">1st - 23rd May 2027 (23 days) / 4th - 26th September 2027 (23 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 10: India Lesser Florican -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/63058861534d3623290bfb52_Florican_Lesser.avif" alt="Lesser Florican" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/lesserflorican2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">India: Lesser Florican and Western Himalaya</a></h5>
                                    <p class="text-muted small mb-1">From Orange Bullfinch to displaying Lesser Florican</p>
                                    <div class="text-success small fw-semibold">22nd/24th July - 4th August 2027 (12 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-available">Two spaces available</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tour 11: Sulawesi outer-islands Cruise -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/691024f651f562527c0d217a_Myna_Bare-eyed%201.avif" alt="Sulawesi Cruise" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/sulawesicruise2027" target="_blank" rel="noopener" class="text-dark text-decoration-none">Sulawesi outer-islands Cruise</a></h5>
                                    <p class="text-muted small mb-1">Taliabu, Peleng, Wangi Wangi, Selayar and Togian</p>
                                    <div class="text-success small fw-semibold">18th October - 2nd November 2027 (16 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-available">One space available</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==============================================
                         2028 SECTION
                         ============================================== -->
                    <div id="2028-tours" class="mb-5 pt-3">
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-2">
                            <h3 class="fw-bold mb-0" style="color: #172b40;">2028 Tours</h3>
                            <span class="badge bg-success">26 Departures</span>
                        </div>

                        <!-- 2028: Southern India -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5eeca26329b176706b577ae5_Bay%20Owl_Sri%20Lanka.avif" alt="Southern India" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/southindia2028" target="_blank" rel="noopener" class="text-dark text-decoration-none">Southern India and Andamans 2028</a></h5>
                                    <p class="text-muted small mb-1">Western Ghats and Andaman &amp; Nicobar endemics</p>
                                    <div class="text-success small fw-semibold">9th - 22nd January 2028 (14 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-full">Tour is full</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2028: Japan Winter -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/65ccb01c35cbfaf65f21b5bd_Eagle_Steller%27s%20Sea%203.avif" alt="Japan Winter 2028" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/japan2028" target="_blank" rel="noopener" class="text-dark text-decoration-none">Japan Classic Winter 2028</a></h5>
                                    <p class="text-muted small mb-1">Cranes, eagles and Blakiston's Fish Owl</p>
                                    <div class="text-success small fw-semibold">15th - 30th January 2028 (16 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-available">Two spaces available</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2028: Sumatra and Java -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6784854885cc7b8dbfbb80aa_Schneider%27s%20Pitta.avif" alt="Sumatra and Java" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/sumatra2028" target="_blank" rel="noopener" class="text-dark text-decoration-none">Sumatra and Java, Indonesia 2028</a></h5>
                                    <p class="text-muted small mb-1">Endemic-filled tour combined with Sundaic treats</p>
                                    <div class="text-success small fw-semibold">2nd - 22nd July 2028 (21 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-available">Four spaces available</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2028: Banda Sea Cruise -->
                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66957dcf4f6c80d173dc3b1e_Ground%20Dove_Wetar.avif" alt="Banda Sea Cruise" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://www.birdtourasia.com/banda2028" target="_blank" rel="noopener" class="text-dark text-decoration-none">Banda Sea Liveaboard Cruise + Tanimbars</a></h5>
                                    <p class="text-muted small mb-1">Tanahjampea, Kalao, Alor, Wetar, Leti, Damar and Babar</p>
                                    <div class="text-success small fw-semibold">3rd - 21st October 2028 (19 days)</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-provisional">Tour is provisionally full</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==============================================
                         FUTURE SECTION
                         ============================================== -->
                    <div id="2029-tours" class="mb-5 pt-3">
                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-2">
                            <h3 class="fw-bold mb-0" style="color: #172b40;">Beyond 2028 (2029 available Dec 2026)</h3>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8aad57a6b2c128ecabeda7_Lorikeet_Kuhl%27s.avif" alt="Eastern Polynesia" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-7 col-8">
                                    <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="https://drive.google.com/file/d/1Eyq-UcUpPVpNg6OoZk1Rd-bTmaj0_lTq/view" target="_blank" rel="noopener" class="text-dark text-decoration-none">Eastern Polynesia</a></h5>
                                    <p class="text-muted small mb-1">Tuamotu, Henderson, Pitcairn, Tahiti, Society and Marquesas</p>
                                    <div class="text-success small fw-semibold">Provisionally September - October, year TBC</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <span class="bta-badge-status bta-badge-provisional">Waiting list available</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
