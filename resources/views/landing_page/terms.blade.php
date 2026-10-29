@extends('layouts.template')

@section('title', 'Terms and Conditions - Birdtour Asia')

@push('styles')
<style>
    .terms-sidebar {
        position: sticky;
        top: 100px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        padding: 24px;
    }

    .terms-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .terms-nav-list li {
        margin-bottom: 8px;
    }

    .terms-nav-list a {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .terms-nav-list a:hover {
        color: #087d50;
        background-color: #f0fdf4;
        padding-left: 16px;
    }

    .terms-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 32px;
        margin-bottom: 28px;
        scroll-margin-top: 110px;
        transition: border-color 0.25s ease;
    }

    .terms-card:hover {
        border-color: #087d50;
    }

    .terms-badge-step {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background-color: #f0fdf4;
        color: #087d50;
        font-weight: 700;
        font-size: 14px;
        margin-right: 12px;
    }

    .terms-card h3 {
        color: #172b40;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .terms-card p {
        color: #4b5563;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 14px;
    }

    .terms-highlight-box {
        background-color: #f8fafc;
        border-left: 4px solid #087d50;
        padding: 18px 22px;
        border-radius: 8px;
        margin: 18px 0;
    }

    .cancellation-table th {
        background-color: #172b40;
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
    }

    .cancellation-table td {
        font-size: 14.5px;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
    <!-- Meeta Hero Slider for Terms Section -->
    <div class="meeta-hero-section position-relative">
        <div class="meeta-hero-slider swiper" aria-label="Birdtour Asia Terms Slider">
            <div class="swiper-wrapper">
                <!-- Slide 1: Western Tragopan -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/666d2a197b96efb3471efbb8_Tragopan_Western_web.avif" alt="Western Tragopan">
                </div>
                <!-- Slide 2: Yellow-eyed Pigeon -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e897b584fbaea57dc200816_Yellow-eyed%20Pigeon%20(40).avif" alt="Yellow-eyed Pigeon">
                </div>
                <!-- Slide 3: Beautiful Nuthatch -->
                <div class="swiper-slide meeta-hero-slide">
                    <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e88864ecce5fb81e3a8c636_Nuthatch_Beautiful%20104.avif" alt="Beautiful Nuthatch">
                </div>
            </div>
        </div>

        <!-- Floating Announcement Overlay (Meeta Theme) -->
        <div class="bta-announcement-overlay">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 11px; letter-spacing: 0.5px;">Legal &amp; Policy</span>
                <span class="text-white-50 small">Booking Conditions</span>
            </div>
            <h4>Terms and Conditions</h4>
            <p>
                Transparent contractual policies, small-group operational standards, and 100% financial insolvency protection under UK &amp; EU Package Travel Regulations.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="#financial-security" class="btn btn-sm btn-primary py-1 px-3">Financial Security &darr;</a>
                <a href="#payment" class="btn btn-sm btn-outline-light py-1 px-3">Payment Terms</a>
                <a href="#cancellations" class="btn btn-sm btn-outline-light py-1 px-3">Cancellations</a>
            </div>
        </div>
    </div>
    <!-- Hero Slider End -->

    <!-- Main Content Area -->
    <div class="section-padding" style="background-color: #ffffff;">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <!-- Left Column: Navigation Sidebar (Desktop) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="terms-sidebar">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <i class="fas fa-file-contract text-success fs-5"></i>
                            <h5 class="fw-bold mb-0 text-dark">Quick Navigation</h5>
                        </div>
                        <ul class="terms-nav-list">
                            <li><a href="#financial-security">1. Financial Security (IPP London)</a></li>
                            <li><a href="#reservations">2. Tour Reservations</a></li>
                            <li><a href="#payment">3. Payment &amp; Currencies</a></li>
                            <li><a href="#cancellations">4. Cancellations &amp; Refunds</a></li>
                            <li><a href="#insurance">5. Travel &amp; Medical Insurance</a></li>
                            <li><a href="#passports-visas">6. Passports &amp; Visa Requirements</a></li>
                            <li><a href="#health">7. Health &amp; Vaccinations</a></li>
                            <li><a href="#room-sharing">8. Sharing Rooms &amp; Single Supplements</a></li>
                            <li><a href="#participation">9. Participation &amp; Code of Conduct</a></li>
                            <li><a href="#tour-alterations">10. Tour Alterations &amp; Flights</a></li>
                            <li><a href="#group-sizes">11. Group Sizes &amp; Ratios</a></li>
                            <li><a href="#price-amendments">12. Price Amendments</a></li>
                            <li><a href="#liability">13. Liability &amp; Land Only Terms</a></li>
                            <li><a href="#complaints">14. Complaints &amp; Governing Law</a></li>
                        </ul>

                        <!-- Download Policy Sheet Card -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="p-3 rounded-3 bg-light border">
                                <span class="badge bg-success mb-2">Insolvency Insurance</span>
                                <h6 class="fw-bold mb-1" style="font-size: 14px;">IPP TOFI Certificate (PDF)</h6>
                                <p class="text-muted small mb-3">Download the official International Passenger Protection summary policy sheet.</p>
                                <a href="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/69100ebdffdd7ff9f2ed2846_Birdtour%20Asia%20Limited%20-%20IPP%20TOFI%20PS%20UK%201%202025.pdf" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm w-100 fw-bold">
                                    <i class="fas fa-file-pdf me-1"></i> Download PDF Policy
                                </a>
                            </div>
                        </div>

                        <!-- Direct Help Box -->
                        <div class="mt-3 p-3 rounded-3 bg-success-subtle text-success border border-success-subtle">
                            <strong class="d-block mb-1"><i class="fab fa-whatsapp me-1"></i> Questions on Booking?</strong>
                            <span class="small d-block text-secondary mb-2">Our tour leaders are happy to answer any questions regarding terms or physical pace.</span>
                            <a href="https://wa.me/60142234220" target="_blank" class="fw-bold text-success text-decoration-none small">&rarr; WhatsApp Us (+60142234220)</a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Full Terms Content -->
                <div class="col-lg-8">

                    <!-- Intro Box -->
                    <div class="terms-card border-success" style="background-color: #f7faf8;">
                        <h2 class="main-title fw-bold mb-3" style="color: #172b40; font-size: 30px;">Birdtour Asia Limited Terms &amp; Conditions</h2>
                        <p class="lead text-secondary mb-0" style="font-size: 16px;">
                            Please read these Booking Conditions carefully. They outline the basis of your contract with <strong>Birdtour Asia Limited</strong> (Company Registration No. 6383052 in England and Wales). When you submit a booking form and pay a deposit, you agree to be bound by all clauses below.
                        </p>
                    </div>

                    <!-- 1. Financial Security -->
                    <div id="financial-security" class="terms-card">
                        <h3><span class="terms-badge-step">1</span> Financial Security &amp; Insolvency Protection</h3>
                        <p>
                            In accordance with <em>"The Package Travel and Linked Travel Arrangements Regulations 2018"</em>, all EU/UK passengers booking a tour are fully protected for all monies paid, arising from cancellation or curtailment of your travel arrangements due to the insolvency of <strong>Birdtour Asia Limited</strong>, who takes all payments.
                        </p>
                        <p>
                            In accordance with the UK Package Travel &amp; Linked Travel Regulations 2018, Directive (EU) 2015/2302 or the local applicable law in the EU country of residence of the passenger(s), bookings with <strong>Birdtour Asia Ltd</strong> are fully protected for the initial deposit and subsequently the balance of all monies received by us, including repatriation costs and arrangements, arising from cancellation or curtailment of your travel arrangements due to the insolvency of <strong>Birdtour Asia Ltd.</strong>
                        </p>
                        <p>
                            The respective laws accordingly to the country of residence of the passenger(s) usually only requires us to provide cover for Package &amp; Linked Travel Arrangements; there is no requirement for Financial Protection of day trips or single elements, and none is provided unless local law requires such. If you have questions on this then please contact <strong>Birdtour Asia Ltd.</strong>
                        </p>

                        <div class="terms-highlight-box">
                            <h6 class="fw-bold text-success mb-2"><i class="fas fa-shield-alt me-1"></i> Policy Underwriters &amp; Claims Contacts</h6>
                            <p class="small mb-3">
                                <strong>Birdtour Asia Ltd</strong> has taken out an insurance provided by <strong>International Passenger Protection Ltd (IPP) with Liberty Mutual Insurance Europe SE (LMIE)</strong> trading as Liberty Specialty Markets, a member of the Liberty Mutual Insurance Group. LMIE's registered office: 5-7 rue Leon Laval, L-3372, Leudelange, Grand Duchy of Luxembourg, Registered Number B232280.
                            </p>
                            <div class="row g-3 small">
                                <div class="col-md-6">
                                    <div class="p-3 bg-white rounded border">
                                        <strong class="d-block text-dark mb-1">For UK Passengers:</strong>
                                        <span class="d-block text-muted">IPP Claims at Sedgwick</span>
                                        <span class="d-block">Tel: +44 (0)345 266 1872</span>
                                        <span class="d-block">Email: <a href="mailto:Insolvency-claims@ipplondon.co.uk" class="text-success">Insolvency-claims@ipplondon.co.uk</a></span>
                                        <span class="d-block">Web: <a href="http://www.ipplondon.co.uk/claims.asp" target="_blank" class="text-success">ipplondon.co.uk/claims.asp</a></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-white rounded border">
                                        <strong class="d-block text-dark mb-1">For EU Passengers:</strong>
                                        <span class="d-block text-muted">IPP Claims at Sedgwick</span>
                                        <span class="d-block">Tel: +31 103120666</span>
                                        <span class="d-block">Email: <a href="mailto:ippclaims@nl.sedgwick.com" class="text-success">ippclaims@nl.sedgwick.com</a></span>
                                        <span class="d-block">Web: <a href="https://www.ipplondon.co.uk/claims.asp" target="_blank" class="text-success">ipplondon.co.uk/claims.asp</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Reservations -->
                    <div id="reservations" class="terms-card">
                        <h3><span class="terms-badge-step">2</span> Reservations</h3>
                        <p>
                            To make a reservation, complete and return the booking form for the tour you are interested in, together with the deposit in the form of a bank transfer, or a U.K. cheque. It is important that under new banking conditions the full title of <strong>Birdtour Asia Limited</strong> is used on all cheques and transfers.
                        </p>
                        <p>
                            Birdtour Asia will then send you written confirmation and an official receipt. It is in your own interest to book early to avoid disappointment as we can only accept reservations strictly in order of receipt. Bookings are welcome up to the last minute subject to availability. Please contact our office for details of current vacancies.
                        </p>
                    </div>

                    <!-- 3. Payment -->
                    <div id="payment" class="terms-card">
                        <h3><span class="terms-badge-step">3</span> Payment &amp; Currency Policy</h3>
                        <p>
                            We accept payment in <strong>Pounds Sterling (&pound; GBP)</strong> or <strong>US Dollars (&dollar; USD)</strong>. Whichever currency you use to make the basic deposit payment must be used for all further payments. Switching of currencies is not permitted. Occasionally tours might include different deposit amounts and payment schedules, and this will be advised in advance.
                        </p>
                        <p>
                            <strong>Balance Schedule:</strong> The balance for all bookings must be paid <strong>120 days before</strong> the tour is due to commence. You will be sent an invoice showing monies paid and the balance due for the tour you have chosen; if the said balance is not paid by the due date, the booking will be deemed to have been cancelled.
                        </p>
                        <div class="alert alert-light border rounded-3 p-3">
                            <p class="small text-muted mb-0">
                                <strong class="text-dark">Payment Methods:</strong> Payment should be by direct bank transfer, or U.K. cheque made out to <em>Birdtour Asia Limited</em>. Please note that we do not accept part payment of deposits or balances, nor post-dated cheques. We do not accept credit or debit cards in order to save clients burdensome processing fee surcharges.
                            </p>
                        </div>
                        <p>
                            After receipt of your balance, we will send you written confirmation of all monies paid, along with pre-trip advisory notes, names of fellow group members, and the bird checklist for your particular tour.
                        </p>
                    </div>

                    <!-- 4. Cancellations -->
                    <div id="cancellations" class="terms-card">
                        <h3><span class="terms-badge-step">4</span> Cancellations &amp; Refunds</h3>
                        <p>
                            Any cancellation must be in writing and signed by whoever signed the booking form. It will take effect on the day we receive it. In the event of you cancelling your booking, the following scale of charges will apply:
                        </p>

                        <div class="table-responsive my-3">
                            <table class="table table-bordered cancellation-table shadow-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Period Before Departure</th>
                                        <th style="width: 50%;">Cancellation Charge Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Over 120 days prior to departure</strong></td>
                                        <td class="text-danger fw-bold">Loss of basic deposit paid for that tour</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Under 120 days prior to departure</strong></td>
                                        <td class="text-danger fw-bold">100% of total tour cost</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p>
                            <strong>Cancellation by Birdtour Asia:</strong> If it becomes necessary that we have to cancel a particular tour, whether it be through insufficient reservations or other factors within our control, then all deposits and other payments will be refunded in full.
                        </p>
                        <p>
                            <strong>Force Majeure:</strong> Should we have to cancel a particular tour due to strikes, war or other political crises, acts of God or other events which amount to force majeure, then we will transfer all monies to an alternative future tour of equivalent itinerary. If this cancellation occurs during the course of the tour then no refund or transfer to another tour is possible. <strong>Travel insurance including cancellation insurance is therefore strictly essential.</strong>
                        </p>
                    </div>

                    <!-- 5. Insurance -->
                    <div id="insurance" class="terms-card">
                        <h3><span class="terms-badge-step">5</span> Travel &amp; Medical Insurance</h3>
                        <p>
                            It is our policy that <strong>all clients must take out comprehensive travel insurance before commencement of a tour</strong>. This insurance should at least cover accident, emergency medical evacuation, medical costs, repatriation, and loss of effects.
                        </p>
                        <p>
                            It should be noted that as the majority of our tours are in developing countries, passenger liability insurance covering the vehicles we hire may be inadequate under local standards. It is therefore important that your insurance cover makes sufficient provision in the event of an accident.
                        </p>
                        <p>
                            It is also most advisable that cover begins from the booking of the tour so as to cover any cancellation charges due to illness or other insurable circumstances prior to the tour commencing.
                        </p>
                    </div>

                    <!-- 6. Passports and Visas -->
                    <div id="passports-visas" class="terms-card">
                        <h3><span class="terms-badge-step">6</span> Passports &amp; Visa Requirements</h3>
                        <p>
                            It is your responsibility to ensure that you have a valid passport and, where necessary, a visa. Your passport must be valid for at least <strong>six months</strong> after the duration of your tour. We accept no responsibility for your failure to comply with these regulations.
                        </p>
                    </div>

                    <!-- 7. Health and Vaccinations -->
                    <div id="health" class="terms-card">
                        <h3><span class="terms-badge-step">7</span> Health &amp; Vaccinations</h3>
                        <p>
                            Because of the constantly changing recommendations as to immunisation requirements, malaria risk or health certificates, it will be your sole responsibility to seek the most up-to-date information from your G.P. or health centre. All costs arising out of failure to comply must be met at your own expense.
                        </p>
                        <p>
                            It cannot be emphasised enough that if you do have a health problem, allergy, or physical limitation, <strong>we need to know about it in advance</strong> so we can be prepared in the case of an emergency.
                        </p>
                    </div>

                    <!-- 8. Sharing Rooms -->
                    <div id="room-sharing" class="terms-card">
                        <h3><span class="terms-badge-step">8</span> Sharing Rooms &amp; Single Supplements</h3>
                        <p>
                            Bookings are accepted only on the understanding that should no room-mate be available, you will accept single accommodation and pay the appropriate single room supplement. (Smokers should kindly note that smoking is strictly not allowed in the room if you are sharing with a non-smoker).
                        </p>
                        <p>
                            Please note that there is no absolute guarantee that single accommodation will always be available at every lodge for those requesting it, and bookings are only accepted on the understanding that the participant agrees to share in the event of an unexpected lack of single accommodation at any remote field location.
                        </p>
                    </div>

                    <!-- 9. Participation & Conduct -->
                    <div id="participation" class="terms-card">
                        <h3><span class="terms-badge-step">9</span> Participation, Fitness &amp; Conduct</h3>
                        <p>
                            It is Birdtour Asia’s aim to take small groups on tours that do not normally entail too much strenuous activity. If on occasions this cannot be avoided it will be made perfectly clear in the tour itinerary. Some destinations will require early morning starts and possibly late returns &mdash; this maximises our opportunities to find and see certain crepuscular species, and as regular wildlife watchers understand, these are by far the most productive times of day.
                        </p>
                        <p>
                            It will be necessary for participants to be able to complete moderate walks over a variety of terrain. It may be of particular interest to note that some of our tours base themselves in one centre; this allows for a flexible itinerary, resulting in a more relaxed tour. There will be the opportunity for those who wish to opt out of any particular excursion and do their own thing at their own expense, provided the itinerary and leader allow.
                        </p>
                        <div class="terms-highlight-box">
                            <strong class="d-block text-dark mb-1">Group Harmony &amp; Code of Conduct:</strong>
                            <p class="small text-muted mb-0">
                                Small groups call for consideration from all participants so that we may all enjoy the tour. Any antisocial behaviour (swearing, smoking etc.) that could be detrimental to the enjoyment of a tour by the other group members shall be deemed unacceptable. If after complaints the leader finds any person still unable to conduct him or herself in a manner seen fit, they reserve the right to send them home without refund.
                            </p>
                        </div>
                        <p>
                            <strong>Tour Reports:</strong> Tour participants agree for their names to be published in our tour report on our website. If a participant objects to this, they must notify the leader in writing within two weeks of the tour's completion.
                        </p>
                    </div>

                    <!-- 10. Tour Alterations -->
                    <div id="tour-alterations" class="terms-card">
                        <h3><span class="terms-badge-step">10</span> Tour Alterations &amp; Flights</h3>
                        <p>
                            Circumstances can change &mdash; weather conditions, transport logistics, political situations, and even bird migration. Because of this, Birdtour Asia and local ground agents reserve the right to change any particular itinerary. If an itinerary has to be changed by the leader while you are on the tour, you must respect their professional decision.
                        </p>
                        <div class="alert alert-warning border rounded-3 p-3">
                            <strong class="text-dark"><i class="fas fa-plane-departure me-1"></i> International Flight Notice:</strong>
                            <p class="small text-muted mb-0">
                                <strong>Do not book international flight arrivals and departures without first having confirmation from Birdtour Asia</strong> regarding dates and timings, as the itineraries shown on tour pages are for illustrative purposes and liable to change.
                            </p>
                        </div>
                    </div>

                    <!-- 11. Group Sizes -->
                    <div id="group-sizes" class="terms-card">
                        <h3><span class="terms-badge-step">11</span> Group Sizes &amp; Leadership Ratios</h3>
                        <p>
                            Birdwatching is best enjoyed in a small group, and we aim to offer the best leader-per-group ratio around. This allows for more personal attention and better opportunities for all group members to see and enjoy the birdlife.
                        </p>
                        <p>
                            To optimize your enjoyment, we restrict clients to a <strong>maximum of between 6–10</strong> per advertised terrestrial tour, with a <strong>minimum of four</strong> for each tour to go ahead. With fewer than four, the tour may have to be cancelled, or if clients wish to go ahead, a small surcharge will be added to the cost of the tour for it to operate.
                        </p>
                    </div>

                    <!-- 12. Price Amendments -->
                    <div id="price-amendments" class="terms-card">
                        <h3><span class="terms-badge-step">12</span> Price Amendments</h3>
                        <p>
                            The price of each tour is calculated well in advance, and unexpected cost changes can sometimes occur. We reserve the right to amend the price of your tour subject to increases or decreases in: governmental action, aircraft fuel, over-flying charges, transport charges, and foreign exchange rates.
                        </p>
                        <p>
                            Even in this case, we will only amend the price (up or down) if changes of <strong>more than 2%</strong> are involved. Should the tour cost increase by <strong>more than 8%</strong>, you will have the right to cancel the tour with a full refund.
                        </p>
                    </div>

                    <!-- 13. Liability -->
                    <div id="liability" class="terms-card">
                        <h3><span class="terms-badge-step">13</span> Liability &amp; Land Only Basis</h3>
                        <p>
                            We have taken all reasonable steps to ensure that the tours published on this website have been properly arranged, and that the travel agents, vehicle hire, hotels, liveaboards, and restaurants are reputable. We accept liability as a direct result of negligence or breach of contractual duty in making arrangements for you, including omissions by our agents.
                        </p>
                        <p>
                            In the case of any loss or damage suffered as a result of our negligence, we limit the maximum extent of our liability to twice the amount paid for the tour in question. We cannot accept liability for claims arising out of carriage by air, sea or land, as we have no control over carriers and you are subject to their conditions governed by international conventions.
                        </p>
                        <p>
                            <strong>Land Only Notice:</strong> All our tours are on a 'land only' basis. Please ensure your flight arrangements allow sufficient time to join the tour on time. If you are late for the planned departure, it is not possible to delay the group, and any costs incurred in catching up will be your own responsibility.
                        </p>
                    </div>

                    <!-- 14. Complaints & Contracts -->
                    <div id="complaints" class="terms-card">
                        <h3><span class="terms-badge-step">14</span> Complaints &amp; Governing Law</h3>
                        <p>
                            In the unlikely event that you have cause to complain, you should notify at least one of your tour leaders as soon as possible in order that we may assist you immediately. If you are not satisfied thereafter, please contact us in writing stating the nature of the complaint within <strong>14 days</strong> of the completion of the tour.
                        </p>
                        <div class="terms-highlight-box">
                            <h6 class="fw-bold text-success mb-2"><i class="fas fa-balance-scale me-1"></i> Contractual Jurisdiction</h6>
                            <p class="small mb-0">
                                When you sign the booking form, you are entering into a contract made with <strong>Birdtour Asia Limited</strong> (Company Registration Number 6383052 in England and Wales), trading as Birdtour Asia, 26 Sutton Avenue, Derby, DE73 6RJ, United Kingdom. The contract is governed exclusively by <strong>English law</strong> and is subject to the exclusive jurisdiction of the English courts.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ==============================================
                 CONSUMER PROTECTION & AFFILIATION LOGOS
                 ============================================== -->
            <div class="row justify-content-center align-items-center g-4 mt-5 pt-4 border-top">
                <div class="col-6 col-md-3 text-center">
                    <a href="https://www.osme.org" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85acdd25acedd02f22a479_OSME.avif" alt="OSME" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <a href="https://www.orientalbirdclub.org" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85acdcfc819766cdaf60c0_OBC_corporate_logo.avif" alt="OBC" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <a href="https://aa.swarovskioptik.com/birding" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/5e85b028c7184277cedee23c_Swarovski.avif" alt="Swarovski Optik" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <a href="https://www.ipplondon.co.uk" target="_blank" rel="noopener">
                        <img src="https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/6539b216589de91ed3511754_198699541d5c923c8508bd343e94a066_IPP.avif" alt="IPP London" class="img-fluid p-2 bg-white rounded shadow-sm" style="max-height: 46px;">
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
