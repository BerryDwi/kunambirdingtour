@extends('layouts.template')

@section('title', 'Tour Leaders - Birdtour Asia')

@section('content')
    <!-- Meeta Hero Slider for Leaders -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Tour Leaders Hero Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Jankowski's Bunting -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/67848ee957c5ce777888bf74_Bunting_Jankowski's.avif" alt="Jankowski's Bunting">
                </div>
                <!-- Slide 2: Himalayan Parakeet -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8458cde22116618e36c237_Parakeet_Himalayan%2012.avif" alt="Himalayan Parakeet">
                </div>
                <!-- Slide 3: Grey-necked Bunting -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/67848596e356d51baca99396_Bunting_Grey-necked.avif" alt="Grey-necked Bunting">
                </div>
                <!-- Slide 4: Twelve-wired Bird-of-paradise -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8ac94306f670981ed7518e_Twelve-wired%20BOP.avif" alt="Twelve-wired Bird-of-paradise">
                </div>
                <!-- Slide 5: Grey-bellied Tesia -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8abc7ba6b2c13ae8ac232b_Tesia_Grey-bellied%2025.avif" alt="Grey-bellied Tesia">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Our Team</span>
            </div>
            <h4>Tour Leaders</h4>
            <p>
                Get to know more about our family, all of whom are based in the region and lead both our scheduled and custom tours.
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
                        <h2 class="main-title fw-bold" style="color: #172b40; font-size: 32px;">Our Leaders</h2>
                        <div class="mx-auto mt-2" style="width: 60px; height: 3px; background-color: #087d50; border-radius: 2px;"></div>
                    </div>

                    <!-- Intro Paragraph -->
                    <div class="lead text-secondary mb-5" style="font-size: 16.5px; line-height: 1.8;">
                        <p class="mb-3">
                            Our leaders are a mix of Asian-based and Asian nationals, whom lead both our scheduled and custom tours. On top of the broad range of scheduled tours offered, we offer a range of custom tours, whether it be extensions to the advertised scheduled tours, but also stand-alone tours. Using Birdtour Asia in-house expertise we can tailor the custom tours to suit your requirements.
                        </p>
                        <p class="mb-0">
                            We use a number of locally-based guides for this, and are actively encouraging and promoting the use of young, keen guides throughout the region. Some of our most popular guides are below, though we also have several other guides who lead custom, private tours with us.
                        </p>
                    </div>

                    <!-- Leaders List -->
                    <div class="d-flex flex-column gap-4">

                        <!-- 1. James Eaton -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6123ab197c07825e9afca2de_James%202.avif" alt="James Eaton" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">James Eaton</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Throughout the region</span>
                                    </div>
                                    <p class="text-secondary mb-2" style="font-size: 14.5px; line-height: 1.7;">
                                        James's teenage years eventually led him east, thinking nothing of skipping college for a long trip with Rob to India! He has built an intimate knowledge of the identification, vocalisations and behaviour of the birds throughout the whole continent. This has resulted in the discovery of several undescribed species in Indonesia in the field, several other cryptic species at his desk resulting from fieldwork, co-authored four new species descriptions, as well as numerous rediscoveries during his visits to over 80 islands within the archipelago. The culmination of his field-time has resulted in the publication of over 100 manuscripts and articles, and lead-author of the <em>Birds of the Indonesian Archipelago</em>.
                                    </p>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        James has a PhD, having studied taxonomically cryptic species and their conservation status. A keen conservationist, with a particular interest in trying to put an end to the bird trade through surveys and research, and a member of the IUCN Asian Songbird Trade, Pigeon &amp; Doves, and Hornbill specialist groups. On top of that, he is an eBird reviewer for Indonesia and Malaysia, and part of the AviList taxonomic committee for Tropical Asia.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Rob Hutchinson -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8bf1729c0c133f906abcf8_Rob%20Hutchinson.avif" alt="Rob Hutchinson" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Rob Hutchinson</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Throughout the region</span>
                                    </div>
                                    <p class="text-secondary mb-2" style="font-size: 14.5px; line-height: 1.7;">
                                        Rob began birding almost as soon as he could lift a pair of binoculars and foreign travel soon developed this into a passion for world birding, with a special interest in the birds of the Oriental region. Since graduating with a BSc in genetics he has travelled throughout the region, visiting many remote areas in search of the region's very rarest birds.
                                    </p>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Rob is an accomplished photographer and keen sound recordist who has authored many scientific papers on the vocalisations, distribution and taxonomy of the region's birds including several elevating little-known forms to species rank. His main interest is his adopted country of the Philippines where he has seen most extant species and co-authored <em>A Naturalists guide to the birds of the Philippines</em>. His travels across the region have netted more than 2,900 species - likely more than anyone else.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Bob Natural -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/69c63d2fa5f7b7fa4d98d5eb_Bob%20Natural.avif" alt="Bob Natural" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Bob Natural</h4>
                                        <span class="badge bg-info-subtle text-info fw-bold px-3 py-1">Office Manager</span>
                                    </div>
                                    <p class="text-secondary mb-2" style="font-size: 14.5px; line-height: 1.7;">
                                        Bob grew up on the island of Masbate in the Bicol Region of the Philippines where he first developed a fascination for the natural world. After earning his degree in Biology at Bicol University he spent several years working with environmental NGOs in the country, contributing to biodiversity conservation on Mindoro and the Polillo Islands.
                                    </p>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        In recent years he has continued his work as a wildlife biologist focusing on migratory shorebirds and Philippine endemics. These days he lives in Batangas from where he works remotely to manage the Birdtour Asia office - he will frequently be your first point of contact with us, and help with any questions you have regarding any aspect of our tours.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Wilbur Goh -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8c2ba0460eb4f7d7523f76_Wilbur.avif" alt="Wilbur Goh" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Wilbur Goh</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">China, Southeast Asia &amp; Papua</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Wilbur is a Malaysian who started birding in his early teens, an obsession which has blossomed into a lifelong love affair with the region's birds. Having travelled the length and breadth of the country for birding, Wilbur knows intimately the habits and calls of Malaysian birds. Birding in other countries throughout Asia has broadened his experience, and he is now one of the more experienced guides in Papua and eastern Indonesia. His easy going, relaxed attitude, even during intense birding days, makes him an extremely popular guide.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Mike Nelson -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e8bf171999957f708b325c8_Mike%20Nelson.avif" alt="Mike Nelson" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Mike Nelson</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Throughout the region</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Mike has been a birder since he was six, when he became fascinated with the birds in his English garden. Having lived in and travelled to over 40 countries, he is an experienced world birder and an avid sound recordist who has logged over 12,000 sound recordings. Working as a full-time guide for Birdtour Asia was a natural progression to share his knowledge and enthusiasm on tours throughout our region.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Shashank Dalvi -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e7da8430e1cdb1c41ae30f6_Shashank.avif" alt="Shashank Dalvi" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Shashank Dalvi</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">India</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Shashank is a researcher and conservationist from India with more than 25 years of field experience. His work led to the discovery of the new bird species Himalayan Forest Thrush, as well as exposing the mass-scale hunting of Amur Falcons in Nagaland. In 2015, Shashank completed a Big Year in India with 1,128 species seen, and he developed the Vannya mobile app used by over 50,000 birdwatchers. He is also the only birder to have spent time on all main Nicobar islands during recent research projects.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Elan James -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66b1ba4c3f0a0f62d7d97c40_Elan.avif" alt="Elan James" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Elan James</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">China</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Elan hails from Jiangxi Province and graduated in 2022 from Nanchang University. He is an up-and-coming talent in the China bird guiding community, having already seen more than 700 species in China. Incredibly sharp in the field, keen on identification issues, his infectious enthusiasm and service-oriented personality make him a firm favourite with everyone he guides.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Boas Emmanuel -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6469951d95b1965bd90d7491_Boas.avif" alt="Boas Emmanuel" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Boas Emmanuel</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Indonesia</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Boas was born in Jakarta and developed a passion for wildlife at a young age. He led his first birding tour in 2010 and now guides across much of the Indonesian archipelago, especially photographic tours targeting endemic pittas. Boas was also part of the Black-browed Babbler survey team that rediscovered the species in Kalimantan in 2021 after it had been lost for over 170 years.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Khaleb Yordan -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e9073ac5a0e49565a208bff_Khaleb.avif" alt="Khaleb Yordan" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Khaleb Yordan</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Indonesia</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Born and raised in Jakarta, Khaleb has gained an intimate knowledge of the endemics and specialities of Java, Bali, Sumatra, Sulawesi, Moluccas and Papua. Khaleb is the perfect guide for custom tours throughout Indonesia, adept at dealing with complex remote itineraries and finding the toughest island specialities.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 10. Wichyanan Limparungpatthanakij -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/640978930f1b4f1e88dbed18_Jay.avif" alt="Jay Limparungpatthanakij" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Wichyanan Limparungpatthanakij (Jay)</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Thailand</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Having seen over 940 species in Thailand, Jay co-authored the <em>Birds of Thailand</em> in 2018 with Uthai Treesucon. He is the regional eBird reviewer for Thailand and a member of both Thai and Philippine Rarities Committees. With over a decade of guiding experience, there really is no one better to guide you through Thailand.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 11. Sumaraja -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6336d4c59532fce156f69e65_Sumaraja.avif" alt="Sumaraja" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Sumaraja</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Indonesia</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        'Raja is a much loved face on all of our Sumatra, Java, Lesser Sundas and Banda Sea tours. He has co-led over 60 tours with us since 2007. Prior to guiding for Birdtour Asia, he was Ben King's right-hand man, including successfully finding Wetar Ground Dove way back in 2008.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 12. Otani Chikara -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/64f15124ed886d13a61500d6_Otani.avif" alt="Otani Chikara" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Otani Chikara</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Japan</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        After graduating from the University of Tokyo, Otani has worked as a researcher and bird guide for nearly 40 years. His passion led him across the world in pursuit of birds, culminating in him authoring Lynx's <em>Birds of Japan</em> field guide.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 13. Tim Dinh -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/65087383e265235e2b71ca01_Tim.avif" alt="Tim Dinh" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Tim Dinh</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Vietnam</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Tim is one of the most experienced and sought-after birdwatching guides in Vietnam. A tour with Tim means having special access to feeding stations, allowing intimate views of Vietnamese endemics like laughingthrushes and babblers.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 14. Martin Kennewell -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/649596bac7f17d4112688d44_Martin.avif" alt="Martin Kennewell" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Martin Kennewell</h4>
                                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Eastern Palaearctic</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Martin has amassed well over 8,000 species worldwide. Based in Asia for over 20 years, mostly in Singapore, he leads Birdtour Asia tours with a focus on the Eastern Palearctic including the Middle East, Mongolia, China and Japan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 15. Frank Rheindt -->
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center p-4">
                                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6ac46a79ca29c5fa58ea2b39_frank.jpg" alt="Frank Rheindt" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" loading="lazy">
                                </div>
                                <div class="col-md-9 p-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <h4 class="fw-bold mb-0" style="color: #172b40; font-size: 22px;">Prof. Frank Rheindt</h4>
                                        <span class="badge bg-warning-subtle text-warning fw-bold px-3 py-1">Guest Co-Leader (Banda Sea 2028)</span>
                                    </div>
                                    <p class="text-secondary mb-0" style="font-size: 14.5px; line-height: 1.7;">
                                        Head of the Avian Evolution Lab at the National University of Singapore, Frank has described roughly a dozen new bird species (including Alor Myzomela) and is Chair of the AviList Taxonomic Committee and co-author of the <em>Birds of the Indonesian Archipelago</em> with James.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Call to Action Box -->
                    <div class="p-4 p-md-5 rounded-4 shadow-sm my-5 text-center" style="background: linear-gradient(135deg, #f7faf8 0%, #eef5ec 100%); border: 1px solid #dce8d8;">
                        <h4 class="fw-bold mb-2" style="color: #172b40;">Plan a Tour with Our Expert Leaders</h4>
                        <p class="text-secondary mb-4 mx-auto" style="max-width: 650px; font-size: 15px;">
                            Whether joining a scheduled small-group tour or organizing a tailor-made private itinerary, our knowledgeable guides are ready to offer advice and guide your journey.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('tours') }}" class="btn btn-primary px-4 py-2 fw-bold">View Scheduled Tours</a>
                            <a href="{{ route('custom-tours') }}" class="btn btn-outline-success px-4 py-2 fw-bold">Plan a Custom Tour</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
