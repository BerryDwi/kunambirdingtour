<?php

namespace Database\Seeders;

use App\Models\TourReport;
use Illuminate\Database\Seeder;

class TourReportSeeder extends Seeder
{
    /**
     * Seed the tour report cards replicated from the public reports page and home page.
     */
    public function run(): void
    {
        $this->seedCategories();
        $this->seedLatestReports();
    }

    /**
     * Seed the twenty report destinations shown on the tour reports page.
     */
    private function seedCategories(): void
    {
        foreach ($this->categories() as $index => $report) {
            TourReport::updateOrCreate(
                ['slug' => $report['slug']],
                $report + [
                    'kind' => 'category',
                    'is_featured' => false,
                    'sort_order' => $index + 1,
                    'is_published' => true,
                ],
            );
        }
    }

    /**
     * Seed the twenty-one latest report cards shown on the home page.
     */
    private function seedLatestReports(): void
    {
        foreach ($this->latestReports() as $index => $report) {
            TourReport::updateOrCreate(
                ['slug' => $report['slug']],
                $report + [
                    'kind' => 'latest',
                    'is_featured' => true,
                    'sort_order' => $index + 1,
                    'is_published' => true,
                ],
            );
        }
    }

    /**
     * The report category cards replicated from the public reports page.
     *
     * @return array<int, array<string, string>>
     */
    private function categories(): array
    {
        $cdn = 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/';

        return [
            [
                'title' => 'Latest reports',
                'slug' => 'latest-reports',
                'summary' => 'Covering all reports from past 12 months',
                'cover_image' => $cdn.'5e820b921fde7d7d67fa83af_Lark_Black.avif',
                'report_url' => 'https://www.birdtourasia.com/latestreports',
            ],
            [
                'title' => 'Borneo',
                'slug' => 'borneo',
                'summary' => 'Sabah, Sarawak and Kalimantan',
                'cover_image' => $cdn.'5e8188459d7551843dcf4500_Blue-headed%20Pitta.avif',
                'report_url' => 'https://www.birdtourasia.com/borneoreports',
            ],
            [
                'title' => 'Cambodia & Laos',
                'slug' => 'cambodia-and-laos',
                'summary' => 'Covering both Cambodia and Laos',
                'cover_image' => $cdn.'5e82035e7ebfdf6a94b98179_Mekong%20Wagtail.avif',
                'report_url' => 'https://www.birdtourasia.com/cambodiareports',
            ],
            [
                'title' => 'Central Asia',
                'slug' => 'central-asia',
                'summary' => 'Kazakstan, Tajikistan and Uzbekistan',
                'cover_image' => $cdn.'5e82fbcb9c4559c8f028987d_Ground-jay_Pander%27s%202.avif',
                'report_url' => 'https://www.birdtourasia.com/turkestanreports',
            ],
            [
                'title' => 'China',
                'slug' => 'china',
                'summary' => 'Xinjiang to Hainan, through to Tibet',
                'cover_image' => $cdn.'5e81ca2e5836db021cc3183c_Pheasant_Reeves%27s.avif',
                'report_url' => 'https://www.birdtourasia.com/chinareports',
            ],
            [
                'title' => 'Indian subcontinent',
                'slug' => 'indian-subcontinent',
                'summary' => 'India, Bangladesh, Pakistan, Nepal & Bhutan',
                'cover_image' => $cdn.'5e7cad606c5cf0508effc029_Ward%27s%20Trogon.avif',
                'report_url' => 'https://www.birdtourasia.com/indiareports',
            ],
            [
                'title' => 'Indonesia - east',
                'slug' => 'indonesia-east',
                'summary' => 'Moluccas, Lesser Sundas, Sulawesi and Banda Sea',
                'cover_image' => $cdn.'5e81ca3089fbd74a14188c18_Ground%20Dove_Wetar.avif',
                'report_url' => 'https://www.birdtourasia.com/wallaceareports',
            ],
            [
                'title' => 'Indonesia - west',
                'slug' => 'indonesia-west',
                'summary' => 'Sumatra, Java, Bali and Kalimantan',
                'cover_image' => $cdn.'5e81a793dad44d1710312ba1_Pitta_Javan%20Banded.avif',
                'report_url' => 'https://www.birdtourasia.com/greatersundasreports',
            ],
            [
                'title' => 'Indonesia - Papua',
                'slug' => 'indonesia-papua',
                'summary' => 'Western half of New Guinea',
                'cover_image' => $cdn.'5e821aba8938a12b63ed2361_Wilson%27s%20BOP.avif',
                'report_url' => 'https://www.birdtourasia.com/papuareports',
            ],
            [
                'title' => 'Japan',
                'slug' => 'japan',
                'summary' => 'Both summer and winter',
                'cover_image' => $cdn.'5e81887629502f883ebe1dbf_Lanceolated%20Warbler.avif',
                'report_url' => 'https://www.birdtourasia.com/japanreports',
            ],
            [
                'title' => 'Malaysia',
                'slug' => 'malaysia',
                'summary' => 'Peninsular Malaysia only. For Sabah & Sarawak, see Borneo',
                'cover_image' => $cdn.'5e81ca2f957e0afe053547b6_Rail-babbler.avif',
                'report_url' => 'https://www.birdtourasia.com/malaysiareports',
            ],
            [
                'title' => 'Middle East',
                'slug' => 'middle-east',
                'summary' => 'Iran, Saudi Arabia, Socotra',
                'cover_image' => $cdn.'625a6235f1fd036fb219c027_Asir%20Magpie.avif',
                'report_url' => 'https://www.birdtourasia.com/middleastreports',
            ],
            [
                'title' => 'Mongolia',
                'slug' => 'mongolia',
                'summary' => 'Spectacular birds in the land of no fences',
                'cover_image' => $cdn.'5e81ca799d75514e69d0825c_Bushchat_Hodgson%27s.avif',
                'report_url' => 'https://www.birdtourasia.com/mongoliareports',
            ],
            [
                'title' => 'Myanmar',
                'slug' => 'myanmar',
                'summary' => "Including a report in search of Gurney's Pitta",
                'cover_image' => $cdn.'5e8179805836db962fc19282_Nuthatch_White-browed-9.avif',
                'report_url' => 'https://www.birdtourasia.com/myanmar-reports',
            ],
            [
                'title' => 'Philippines',
                'slug' => 'philippines',
                'summary' => 'Including scheduled, custom and remote tours',
                'cover_image' => $cdn.'5e81ca2fdc5445aadaf8763b_Pitta_Whiskered.avif',
                'report_url' => 'https://www.birdtourasia.com/philippinesreports',
            ],
            [
                'title' => 'Thailand',
                'slug' => 'thailand',
                'summary' => 'Solely custom tours',
                'cover_image' => $cdn.'5f2ce3b49c554ee3bb96734f_Siamese%20Fireback.avif',
                'report_url' => 'https://www.birdtourasia.com/thailandreports',
            ],
            [
                'title' => 'Timor Leste',
                'slug' => 'timor-leste',
                'summary' => 'A solitary report in search of its specialities',
                'cover_image' => $cdn.'5e81feaeae87b81665ed2e8a_Timor%20Coucal.avif',
                'report_url' => 'https://www.birdtourasia.com/timorlestereports',
            ],
            [
                'title' => 'Vietnam',
                'slug' => 'vietnam',
                'summary' => 'Comprehensive tour reports from north to south',
                'cover_image' => $cdn.'5e81d48d6e9ef015df0902d2_Pitta_Bar-bellied.avif',
                'report_url' => 'https://www.birdtourasia.com/vietnamreports',
            ],
            [
                'title' => 'Eastern Polynesia',
                'slug' => 'eastern-polynesia',
                'summary' => 'Our mammoth 39-day 2019 tour report',
                'cover_image' => $cdn.'5e8aad57a6b2c128ecabeda7_Lorikeet_Kuhl%27s.avif',
                'report_url' => 'https://drive.google.com/open?id=1Eyq-UcUpPVpNg6OoZk1Rd-bTmaj0_lTq',
            ],
            [
                'title' => 'Newsletters',
                'slug' => 'newsletters',
                'summary' => 'Our annual <em>The Banded Pitta</em>',
                'cover_image' => $cdn.'62cd9bd6b8cf054adf66fe09_Screenshot%202022-07-12%20at%2009.01.54.avif',
                'report_url' => 'https://www.birdtourasia.com/newsletter',
            ],
        ];
    }

    /**
     * The latest report cards replicated from the public home page.
     *
     * @return array<int, array<string, string>>
     */
    private function latestReports(): array
    {
        $cdn = 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/';

        return [
            [
                'title' => 'Lesser Florican & Western Himalaya',
                'slug' => 'lesser-florican-western-himalaya',
                'summary' => 'July - August 2026',
                'cover_image' => $cdn.'63058861534d3623290bfb52_Florican_Lesser.avif',
                'report_url' => 'https://tinyurl.com/btaflorican26',
            ],
            [
                'title' => 'Philippines Endemic Bonanza',
                'slug' => 'philippines-endemic-bonanza',
                'summary' => 'February - March 2026',
                'cover_image' => $cdn.'5f50cf2c9ebeb51c96818042_Palawan%20Peacock%20Pheasant_Large.avif',
                'report_url' => 'https://tinyurl.com/btaphilippinesbonanza26',
            ],
            [
                'title' => 'Central Asia & Caucasus',
                'slug' => 'central-asia-caucasus',
                'summary' => 'May 2026',
                'cover_image' => $cdn.'62fa29f8d42bad02037292ab_Plover_Caspian.avif',
                'report_url' => 'https://tinyurl.com/btaturkistan26',
            ],
            [
                'title' => 'Sumatra and Java',
                'slug' => 'sumatra-and-java',
                'summary' => 'July - August 2026',
                'cover_image' => $cdn.'649122e41339581aa2361b10_Sumatran%20Ground%20Cuckoo.avif',
                'report_url' => 'https://tinyurl.com/btasumatra26',
            ],
            [
                'title' => 'Xinjiang and Tibetan Plateau',
                'slug' => 'xinjiang-and-tibetan-plateau',
                'summary' => 'June - July 2026',
                'cover_image' => $cdn.'5e86ee6b69567561926d9f68_Pinktail_Przewalski%27s%2084.avif',
                'report_url' => 'https://tinyurl.com/btatibet26',
            ],
            [
                'title' => 'The Banded Pitta 23',
                'slug' => 'the-banded-pitta-23',
                'summary' => 'Summer Newsletter 2026',
                'cover_image' => $cdn.'6a48b4e44ece1b870dd16870_bandedpitta23.avif',
                'report_url' => 'https://tinyurl.com/thebandedpitta23',
            ],
            [
                'title' => 'Sichuan',
                'slug' => 'sichuan',
                'summary' => 'May - June 2026',
                'cover_image' => $cdn.'66d13a8060de3ad3deb00499_Temminck%27s%20Tragopan.avif',
                'report_url' => 'https://tinyurl.com/btasichuan26',
            ],
            [
                'title' => 'Northeast India',
                'slug' => 'northeast-india',
                'summary' => 'April - May 2026',
                'cover_image' => $cdn.'5e7cad606c5cf0508effc029_Ward%27s%20Trogon.avif',
                'report_url' => 'https://tinyurl.com/btaeaglenest26',
            ],
            [
                'title' => 'Peninsular Malaysia',
                'slug' => 'peninsular-malaysia',
                'summary' => 'June - July 2026',
                'cover_image' => $cdn.'5e889c52bebe7dcf16fe9468_Plain-pouched%20Hornbill.avif',
                'report_url' => 'https://tinyurl.com/btamalaysia26',
            ],
            [
                'title' => 'West India',
                'slug' => 'west-india',
                'summary' => 'January - February 2026',
                'cover_image' => $cdn.'666bdbb4f7f67dffa7ce9cc0_Bullfinch_Orange.avif',
                'report_url' => 'https://tinyurl.com/btawestindia26',
            ],
            [
                'title' => 'South India & Andamans',
                'slug' => 'south-india-andamans',
                'summary' => 'January 2026',
                'cover_image' => $cdn.'5e8886e8a6b2c149baa0faa3_Thrush_Nilgiri%2018.avif',
                'report_url' => 'https://tinyurl.com/btaandamans26',
            ],
            [
                'title' => 'Tajikistan and Pakistan',
                'slug' => 'tajikistan-and-pakistan',
                'summary' => 'May - June 2026',
                'cover_image' => $cdn.'666bdbb4f7f67dffa7ce9cc0_Bullfinch_Orange.avif',
                'report_url' => 'https://tinyurl.com/btatajikistan26',
            ],
            [
                'title' => 'Japan in Spring',
                'slug' => 'japan-in-spring',
                'summary' => 'May - June 2026',
                'cover_image' => $cdn.'5f1ae933e5f8874c2bfd3bd8_96f7f094bba6aad7a4619036313bd9d2_Copper%20Pheasant.avif',
                'report_url' => 'https://tinyurl.com/btajapan26',
            ],
            [
                'title' => 'East China',
                'slug' => 'east-china',
                'summary' => 'May 2026',
                'cover_image' => $cdn.'5e81ca2e5836db021cc3183c_Pheasant_Reeves%27s.avif',
                'report_url' => 'https://tinyurl.com/eastchina26',
            ],
            [
                'title' => 'China in Winter',
                'slug' => 'china-in-winter',
                'summary' => 'January - February 2026',
                'cover_image' => $cdn.'66018305014df47ecaf6f140_Crane_Siberian%203.avif',
                'report_url' => 'https://tinyurl.com/btachinawinter26',
            ],
            [
                'title' => 'Vietnam 2026',
                'slug' => 'vietnam-2026',
                'summary' => 'February - March 2026',
                'cover_image' => $cdn.'5e81d48d6e9ef015df0902d2_Pitta_Bar-bellied.avif',
                'report_url' => 'https://tinyurl.com/btavietnam26',
            ],
            [
                'title' => 'Intrepid Philippines 2026',
                'slug' => 'intrepid-philippines-2026',
                'summary' => 'March - April 2026',
                'cover_image' => $cdn.'6868d917369d6171530b3407_Visayan%20Wattled%20Broadbill_Bohol.avif',
                'report_url' => 'https://tinyurl.com/btaintrepidphilippines26',
            ],
            [
                'title' => 'Japan in Winter',
                'slug' => 'japan-in-winter',
                'summary' => 'January 2026',
                'cover_image' => $cdn.'65ccb01c35cbfaf65f21b5bd_Eagle_Steller%27s%20Sea%203.avif',
                'report_url' => 'https://tinyurl.com/btajapanwinter26',
            ],
            [
                'title' => 'China Winter Custom - eBird',
                'slug' => 'china-winter-custom-ebird',
                'summary' => 'February - March 2026',
                'cover_image' => $cdn.'66018305014df47ecaf6f140_Crane_Siberian%203.avif',
                'report_url' => 'https://ebird.org/tripreport/480781',
            ],
            [
                'title' => 'Bangladesh',
                'slug' => 'bangladesh',
                'summary' => 'January 2026',
                'cover_image' => $cdn.'699595a915e9b7d6032729e4_finfoot%20female.avif',
                'report_url' => 'https://tinyurl.com/btabangladesh26',
            ],
            [
                'title' => 'Sulawesi Islands Cruise',
                'slug' => 'sulawesi-islands-cruise',
                'summary' => 'October 2025',
                'cover_image' => $cdn.'691024f651f562527c0d217a_Myna_Bare-eyed%201.avif',
                'report_url' => 'https://tinyurl.com/sulawesicruise',
            ],
        ];
    }
}
