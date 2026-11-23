<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed the site-wide settings replicated from the current public pages.
     */
    public function run(): void
    {
        foreach ($this->settings() as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'] ?? 'string',
                    'group' => $setting['group'],
                ],
            );
        }
    }

    /**
     * The settings replicated from the existing public layout and pages.
     *
     * @return array<int, array{key: string, value: string, group: string, type?: string}>
     */
    private function settings(): array
    {
        return [
            // General
            ['key' => 'site_name', 'value' => 'Kunam Birding Tours', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Specialists in Asian Birding Tours', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Specialists in Asian birding tours, we offer the best in organised and tailor-made tours throughout the continent, from the Middle-east to New Guinea.', 'group' => 'general', 'type' => 'text'],
            ['key' => 'company_name', 'value' => 'Birdtour Asia Limited', 'group' => 'general'],
            ['key' => 'company_registration', 'value' => '6383052', 'group' => 'general'],
            ['key' => 'company_address', 'value' => '26 Sutton Avenue, Derby, DE73 6RJ, United Kingdom', 'group' => 'general'],
            ['key' => 'footer_copyright_start', 'value' => '2005', 'group' => 'general'],

            // Contact
            ['key' => 'contact_email', 'value' => 'info@birdtourasia.com', 'group' => 'contact'],
            ['key' => 'office_email', 'value' => 'office@birdtourasia.com', 'group' => 'contact'],
            ['key' => 'whatsapp_primary_name', 'value' => 'James Eaton', 'group' => 'contact'],
            ['key' => 'whatsapp_primary_number', 'value' => '+60142234220', 'group' => 'contact'],
            ['key' => 'whatsapp_secondary_name', 'value' => 'Rob Hutchinson', 'group' => 'contact'],
            ['key' => 'whatsapp_secondary_number', 'value' => '+63 920 831 6564', 'group' => 'contact'],

            // Bank details
            ['key' => 'bank_account_name', 'value' => 'Birdtour Asia Limited', 'group' => 'bank'],
            ['key' => 'bank_name', 'value' => 'NatWest Bank Plc', 'group' => 'bank'],
            ['key' => 'bank_gbp_sort_code', 'value' => '60-06-33', 'group' => 'bank'],
            ['key' => 'bank_gbp_account_number', 'value' => '48920114', 'group' => 'bank'],
            ['key' => 'bank_gbp_iban', 'value' => 'GB17 NWBK 6006 3348 9201 14', 'group' => 'bank'],
            ['key' => 'bank_gbp_bic', 'value' => 'NWBK GB 2L', 'group' => 'bank'],
            ['key' => 'bank_gbp_pdf_url', 'value' => 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66c2dec4fb85b8aa220c4cc7_Birdtour%20Asia%20Limited%20bank%20details%20GBP.pdf', 'group' => 'bank'],
            ['key' => 'bank_usd_account_number', 'value' => '140-0-03094892', 'group' => 'bank'],
            ['key' => 'bank_usd_swift', 'value' => 'NWBK GB 2L', 'group' => 'bank'],
            ['key' => 'bank_usd_country', 'value' => 'United Kingdom', 'group' => 'bank'],
            ['key' => 'bank_usd_pdf_url', 'value' => 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/66c2dec488add2c72f8fa83a_Birdtour%20Asia%20Limited%20bank%20details%20USD.pdf', 'group' => 'bank'],

            // Social
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/birdtourasia', 'group' => 'social'],
            ['key' => 'facebook_button_label', 'value' => 'Visit Facebook Page', 'group' => 'social'],

            // Home page
            ['key' => 'home_announcement_badge', 'value' => 'Field Update', 'group' => 'home'],
            ['key' => 'home_announcement_date', 'value' => '14/10 Announcement', 'group' => 'home'],
            ['key' => 'home_announcement_title', 'value' => 'Latest news 14/10', 'group' => 'home'],
            ['key' => 'home_announcement_body', 'value' => '2027: we have spaces on Laos and Cambodia in March, Lesser Florican & Western Himalaya tour in July and Sulawesi islands Cruise.', 'group' => 'home', 'type' => 'text'],
            ['key' => 'home_announcement_cta_label', 'value' => 'View 2027 Departures', 'group' => 'home'],
            ['key' => 'home_announcement_cta_url', 'value' => '/tours', 'group' => 'home'],
            ['key' => 'home_about_title', 'value' => 'Specialists in Asian Birding Tours', 'group' => 'home'],
            ['key' => 'home_about_body', 'value' => implode("\n\n", [
                'Kunam Birding Tours are the specialists in birding tours, offering the best in organised and tailor-made custom tours throughout the region for 20 years. We offer you the best possible bird-tour experience through a combination of the most experienced and knowledgeable leaders in the region, small group sizes, a friendly and relaxed atmosphere, and of course some of the finest birding in the world.',
                'Our tours cover a huge swathe from Saudi Arabia and Socotra in the west, to the Kamchatka coastline in the north, and as far east as West Papua in New Guinea. We carefully plan each tour to optimise the birding opportunities at each site visited, concentrating on the most enigmatic, localised and hard to find species. By allowing time for comprehensive coverage we will give ourselves the best realistic chance of locating these speciality birds of the region.',
                'Our scheduled tours are equalled in popularity by our custom tours, with itineraries designed with the intimate knowledge of our Kunam Birding Tours team to match your needs for any bird targets, mammals, culture or cuisine.',
                'Please visit our tours page for our 2026-2028 scheduled departures or contact us by e-mail or WhatsApp if you would like us to organise one of our popular custom tours. Our 2029 tour calendar will be published in December 2026.',
            ]), 'group' => 'home', 'type' => 'text'],
            ['key' => 'home_award_title', 'value' => '100% Survey Score & Top Ranked Operator', 'group' => 'home'],
            ['key' => 'home_award_text', 'value' => 'We take great pride in the positive feedback and testimonials from our past participants: we were the only tour company to score 100% in every category in a Birdwatch Magazine survey, as well as placing number one by Stride (www.stridetravel.com) in their Top 10 Birdwatching tour operators.', 'group' => 'home', 'type' => 'text'],
            ['key' => 'home_facebook_title', 'value' => 'Latest news from the field', 'group' => 'home'],
            ['key' => 'home_facebook_text', 'value' => 'Our Facebook page has regular updates from the field and tour photo albums, along with instant messaging support.', 'group' => 'home', 'type' => 'text'],
            ['key' => 'home_reports_title', 'value' => 'Selected Latest Tour Reports', 'group' => 'home'],
            ['key' => 'home_reports_subtitle', 'value' => 'Explore recent trip highlights, species lists, and dispatches from across Asia', 'group' => 'home'],

            // SEO
            ['key' => 'meta_title', 'value' => 'Kunam Birding Tours: birding tours throughout the continent', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Specialists in Asian birding tours, we offer the best in organised and tailor-made tours throughout the continent, from the Middle-east to New Guinea.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_image', 'value' => '', 'group' => 'seo'],
            ['key' => 'meta_title_tours', 'value' => 'Scheduled Tours Calendar - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_tours', 'value' => 'Browse Kunam Birding Tours scheduled birding tours for 2027 and 2028, with small groups and expert leaders across Asia.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_title_custom_tours', 'value' => 'Custom tours - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_custom_tours', 'value' => 'Design a tailor-made birding tour with Kunam Birding Tours, built around your target species, dates, and travel style.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_title_tour_reports', 'value' => 'Tour Reports - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_tour_reports', 'value' => 'Read recent Kunam Birding Tours tour reports with trip highlights, species lists, and field dispatches from across Asia.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_title_leaders', 'value' => 'Tour Leaders - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_leaders', 'value' => 'Meet the experienced Kunam Birding Tours tour leaders who guide our scheduled and custom birding tours across Asia.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_title_booking', 'value' => 'Booking with us - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_booking', 'value' => 'Book a Kunam Birding Tours birding tour online, review payment details, and reserve your place with our team.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_title_contact', 'value' => 'Contact us - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_contact', 'value' => 'Contact Kunam Birding Tours to ask about scheduled departures, custom birding tours, or your existing booking.', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_title_terms', 'value' => 'Terms and Conditions - Kunam Birding Tours', 'group' => 'seo'],
            ['key' => 'meta_description_terms', 'value' => 'Kunam Birding Tours booking terms and conditions, including payments, cancellations, insurance, and travel arrangements.', 'group' => 'seo', 'type' => 'text'],
        ];
    }
}
