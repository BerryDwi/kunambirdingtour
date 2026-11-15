<?php

namespace Database\Seeders;

use App\Models\TermsSection;
use Illuminate\Database\Seeder;

class TermsSectionSeeder extends Seeder
{
    /**
     * Seed the booking conditions replicated from the public terms page.
     */
    public function run(): void
    {
        foreach ($this->sections() as $index => $section) {
            TermsSection::updateOrCreate(
                ['number' => $section['number']],
                $section + [
                    'nav_title' => $this->navTitles()[$section['number']] ?? null,
                    'anchor' => $this->anchors()[$section['number']] ?? null,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }

    /**
     * The quick navigation labels replicated from the public terms sidebar.
     *
     * @return array<int, string>
     */
    private function navTitles(): array
    {
        return [
            1 => 'Financial Security (IPP London)',
            2 => 'Tour Reservations',
            3 => 'Payment & Currencies',
            4 => 'Cancellations & Refunds',
            5 => 'Travel & Medical Insurance',
            6 => 'Passports & Visa Requirements',
            7 => 'Health & Vaccinations',
            8 => 'Sharing Rooms & Single Supplements',
            9 => 'Participation & Code of Conduct',
            10 => 'Tour Alterations & Flights',
            11 => 'Group Sizes & Ratios',
            12 => 'Price Amendments',
            13 => 'Liability & Land Only Terms',
            14 => 'Complaints & Governing Law',
        ];
    }

    /**
     * The section anchors replicated from the public terms navigation.
     *
     * @return array<int, string>
     */
    private function anchors(): array
    {
        return [
            1 => 'financial-security',
            2 => 'reservations',
            3 => 'payment',
            4 => 'cancellations',
            5 => 'insurance',
            6 => 'passports-visas',
            7 => 'health',
            8 => 'room-sharing',
            9 => 'participation',
            10 => 'tour-alterations',
            11 => 'group-sizes',
            12 => 'price-amendments',
            13 => 'liability',
            14 => 'complaints',
        ];
    }

    /**
     * The fourteen terms sections replicated from the public terms page.
     *
     * @return array<int, array{number: int, title: string, body: string}>
     */
    private function sections(): array
    {
        return [
            [
                'number' => 1,
                'title' => 'Financial Security & Insolvency Protection',
                'body' => <<<'HTML'
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
HTML,
            ],
            [
                'number' => 2,
                'title' => 'Reservations',
                'body' => <<<'HTML'
<p>
    To make a reservation, complete and return the booking form for the tour you are interested in, together with the deposit in the form of a bank transfer, or a U.K. cheque. It is important that under new banking conditions the full title of <strong>Birdtour Asia Limited</strong> is used on all cheques and transfers.
</p>
<p>
    Birdtour Asia will then send you written confirmation and an official receipt. It is in your own interest to book early to avoid disappointment as we can only accept reservations strictly in order of receipt. Bookings are welcome up to the last minute subject to availability. Please contact our office for details of current vacancies.
</p>
HTML,
            ],
            [
                'number' => 3,
                'title' => 'Payment & Currency Policy',
                'body' => <<<'HTML'
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
HTML,
            ],
            [
                'number' => 4,
                'title' => 'Cancellations & Refunds',
                'body' => <<<'HTML'
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
HTML,
            ],
            [
                'number' => 5,
                'title' => 'Travel & Medical Insurance',
                'body' => <<<'HTML'
<p>
    It is our policy that <strong>all clients must take out comprehensive travel insurance before commencement of a tour</strong>. This insurance should at least cover accident, emergency medical evacuation, medical costs, repatriation, and loss of effects.
</p>
<p>
    It should be noted that as the majority of our tours are in developing countries, passenger liability insurance covering the vehicles we hire may be inadequate under local standards. It is therefore important that your insurance cover makes sufficient provision in the event of an accident.
</p>
<p>
    It is also most advisable that cover begins from the booking of the tour so as to cover any cancellation charges due to illness or other insurable circumstances prior to the tour commencing.
</p>
HTML,
            ],
            [
                'number' => 6,
                'title' => 'Passports & Visa Requirements',
                'body' => <<<'HTML'
<p>
    It is your responsibility to ensure that you have a valid passport and, where necessary, a visa. Your passport must be valid for at least <strong>six months</strong> after the duration of your tour. We accept no responsibility for your failure to comply with these regulations.
</p>
HTML,
            ],
            [
                'number' => 7,
                'title' => 'Health & Vaccinations',
                'body' => <<<'HTML'
<p>
    Because of the constantly changing recommendations as to immunisation requirements, malaria risk or health certificates, it will be your sole responsibility to seek the most up-to-date information from your G.P. or health centre. All costs arising out of failure to comply must be met at your own expense.
</p>
<p>
    It cannot be emphasised enough that if you do have a health problem, allergy, or physical limitation, <strong>we need to know about it in advance</strong> so we can be prepared in the case of an emergency.
</p>
HTML,
            ],
            [
                'number' => 8,
                'title' => 'Sharing Rooms & Single Supplements',
                'body' => <<<'HTML'
<p>
    Bookings are accepted only on the understanding that should no room-mate be available, you will accept single accommodation and pay the appropriate single room supplement. (Smokers should kindly note that smoking is strictly not allowed in the room if you are sharing with a non-smoker).
</p>
<p>
    Please note that there is no absolute guarantee that single accommodation will always be available at every lodge for those requesting it, and bookings are only accepted on the understanding that the participant agrees to share in the event of an unexpected lack of single accommodation at any remote field location.
</p>
HTML,
            ],
            [
                'number' => 9,
                'title' => 'Participation, Fitness & Conduct',
                'body' => <<<'HTML'
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
HTML,
            ],
            [
                'number' => 10,
                'title' => 'Tour Alterations & Flights',
                'body' => <<<'HTML'
<p>
    Circumstances can change &mdash; weather conditions, transport logistics, political situations, and even bird migration. Because of this, Birdtour Asia and local ground agents reserve the right to change any particular itinerary. If an itinerary has to be changed by the leader while you are on the tour, you must respect their professional decision.
</p>
<div class="alert alert-warning border rounded-3 p-3">
    <strong class="text-dark"><i class="fas fa-plane-departure me-1"></i> International Flight Notice:</strong>
    <p class="small text-muted mb-0">
        <strong>Do not book international flight arrivals and departures without first having confirmation from Birdtour Asia</strong> regarding dates and timings, as the itineraries shown on tour pages are for illustrative purposes and liable to change.
    </p>
</div>
HTML,
            ],
            [
                'number' => 11,
                'title' => 'Group Sizes & Leadership Ratios',
                'body' => <<<'HTML'
<p>
    Birdwatching is best enjoyed in a small group, and we aim to offer the best leader-per-group ratio around. This allows for more personal attention and better opportunities for all group members to see and enjoy the birdlife.
</p>
<p>
    To optimize your enjoyment, we restrict clients to a <strong>maximum of between 6&ndash;10</strong> per advertised terrestrial tour, with a <strong>minimum of four</strong> for each tour to go ahead. With fewer than four, the tour may have to be cancelled, or if clients wish to go ahead, a small surcharge will be added to the cost of the tour for it to operate.
</p>
HTML,
            ],
            [
                'number' => 12,
                'title' => 'Price Amendments',
                'body' => <<<'HTML'
<p>
    The price of each tour is calculated well in advance, and unexpected cost changes can sometimes occur. We reserve the right to amend the price of your tour subject to increases or decreases in: governmental action, aircraft fuel, over-flying charges, transport charges, and foreign exchange rates.
</p>
<p>
    Even in this case, we will only amend the price (up or down) if changes of <strong>more than 2%</strong> are involved. Should the tour cost increase by <strong>more than 8%</strong>, you will have the right to cancel the tour with a full refund.
</p>
HTML,
            ],
            [
                'number' => 13,
                'title' => 'Liability & Land Only Basis',
                'body' => <<<'HTML'
<p>
    We have taken all reasonable steps to ensure that the tours published on this website have been properly arranged, and that the travel agents, vehicle hire, hotels, liveaboards, and restaurants are reputable. We accept liability as a direct result of negligence or breach of contractual duty in making arrangements for you, including omissions by our agents.
</p>
<p>
    In the case of any loss or damage suffered as a result of our negligence, we limit the maximum extent of our liability to twice the amount paid for the tour in question. We cannot accept liability for claims arising out of carriage by air, sea or land, as we have no control over carriers and you are subject to their conditions governed by international conventions.
</p>
<p>
    <strong>Land Only Notice:</strong> All our tours are on a 'land only' basis. Please ensure your flight arrangements allow sufficient time to join the tour on time. If you are late for the planned departure, it is not possible to delay the group, and any costs incurred in catching up will be your own responsibility.
</p>
HTML,
            ],
            [
                'number' => 14,
                'title' => 'Complaints & Governing Law',
                'body' => <<<'HTML'
<p>
    In the unlikely event that you have cause to complain, you should notify at least one of your tour leaders as soon as possible in order that we may assist you immediately. If you are not satisfied thereafter, please contact us in writing stating the nature of the complaint within <strong>14 days</strong> of the completion of the tour.
</p>
<div class="terms-highlight-box">
    <h6 class="fw-bold text-success mb-2"><i class="fas fa-balance-scale me-1"></i> Contractual Jurisdiction</h6>
    <p class="small mb-0">
        When you sign the booking form, you are entering into a contract made with <strong>Birdtour Asia Limited</strong> (Company Registration Number 6383052 in England and Wales), trading as Birdtour Asia, 26 Sutton Avenue, Derby, DE73 6RJ, United Kingdom. The contract is governed exclusively by <strong>English law</strong> and is subject to the exclusive jurisdiction of the English courts.
    </p>
</div>
HTML,
            ],
        ];
    }
}
