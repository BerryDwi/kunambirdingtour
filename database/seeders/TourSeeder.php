<?php

namespace Database\Seeders;

use App\Enums\TourStatus;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TourSeeder extends Seeder
{
    /**
     * Seed the scheduled tours replicated from the public tours calendar.
     */
    public function run(): void
    {
        $content = $this->content();

        foreach ($this->tours() as $index => $tour) {
            Tour::updateOrCreate(
                ['slug' => $tour['slug']],
                $tour + ($content[$tour['slug']] ?? []) + [
                    'status_label' => $this->statusLabels()[$tour['slug']] ?? null,
                    'is_featured' => false,
                    'is_published' => true,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }

    /**
     * Placeholder descriptions, itineraries and group sizes copied from the previous public tour pages.
     *
     * @return array<string, array{description: string|null, itinerary: string|null, group_size: string|null}>
     */
    private function content(): array
    {
        $path = database_path('seeders/data/tour-content.json');

        if (! File::exists($path)) {
            return [];
        }

        return json_decode(File::get($path), true) ?? [];
    }

    /**
     * Badge labels that differ from the generic tour status label.
     *
     * @return array<string, string>
     */
    private function statusLabels(): array
    {
        return [
            'cambodia-and-laos-2027' => 'One space available',
            'sulawesi-outer-islands-cruise-2027' => 'One space available',
            'india-lesser-florican-and-western-himalaya-2027' => 'Two spaces available',
            'japan-classic-winter-2028' => 'Two spaces available',
            'sumatra-and-java-indonesia-2028' => 'Four spaces available',
            'banda-sea-liveaboard-cruise-tanimbars-2028' => 'Tour is provisionally full',
            'eastern-polynesia' => 'Waiting list available',
        ];
    }

    /**
     * The tour cards replicated from the public tours page.
     *
     * @return array<int, array<string, mixed>>
     */
    private function tours(): array
    {
        $cdn = 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/';

        return [
            [
                'name' => 'China in winter',
                'slug' => 'china-in-winter-2027',
                'year' => 2027,
                'country' => 'China',
                'summary' => 'Covering Beijing to Hainan and across to Yunnan',
                'duration_days' => 20,
                'date_label' => '10th - 29th January 2027 (20 days) / 20th February - 12th March 2027 (20 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'66018305014df47ecaf6f140_Crane_Siberian%203.avif',
                'meta_title' => 'China in winter 2027',
                'meta_description' => 'Covering Beijing to Hainan and across to Yunnan.',
            ],
            [
                'name' => 'Southern India and Andamans',
                'slug' => 'southern-india-and-andamans-2027',
                'year' => 2027,
                'country' => 'India',
                'summary' => 'Western Ghats and Andaman & Nicobar endemics (can be combined with West India)',
                'duration_days' => 15,
                'date_label' => '10th - 24th January 2027 (15 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'5e8886e7bebe7d67b7fe2021_Owl_Andaman%20Scops.avif',
                'meta_title' => 'Southern India and Andamans 2027',
                'meta_description' => 'Western Ghats and Andaman & Nicobar endemics.',
            ],
            [
                'name' => 'West India',
                'slug' => 'west-india-2027',
                'year' => 2027,
                'country' => 'India',
                'summary' => 'Punjab, Rajasthan, Gujarat and Maharashtra + Orange Bullfinch extension',
                'duration_days' => 18,
                'date_label' => '25th January - 11th / 14th February 2027 (18 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'5e822da115c85a3ad6f937d2_Green%20Avadavat.avif',
                'meta_title' => 'West India 2027',
                'meta_description' => 'Punjab, Rajasthan, Gujarat and Maharashtra with the Orange Bullfinch extension.',
            ],
            [
                'name' => 'Bangladesh',
                'slug' => 'bangladesh-2027',
                'year' => 2027,
                'country' => 'Bangladesh',
                'summary' => 'The original Masked Finfoot boat experience',
                'duration_days' => 11,
                'date_label' => '24th January - 1st February 2027 (11 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'699595a915e9b7d6032729e4_finfoot%20female.avif',
                'meta_title' => 'Bangladesh 2027',
                'meta_description' => 'The original Masked Finfoot boat experience.',
            ],
            [
                'name' => 'Japan: Classic Winter',
                'slug' => 'japan-classic-winter-2027',
                'year' => 2027,
                'country' => 'Japan',
                'summary' => "Steller's Sea Eagle, Red-crowned Cranes, Blakiston's Fish Owl",
                'duration_days' => 16,
                'date_label' => '3rd - 18th February 2027 (16 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'65ccb01c35cbfaf65f21b5bd_Eagle_Steller%27s%20Sea%203.avif',
                'meta_title' => 'Japan: Classic Winter 2027',
                'meta_description' => "Steller's Sea Eagle, Red-crowned Cranes and Blakiston's Fish Owl.",
            ],
            [
                'name' => 'Cambodia and Laos',
                'slug' => 'cambodia-and-laos-2027',
                'year' => 2027,
                'country' => 'Cambodia',
                'summary' => 'Critically Endangered specialities + Cambodian Laughingthrush extension',
                'duration_days' => 14,
                'date_label' => '28th February - 10th / 14th March 2027 (11 / 14 days)',
                'status' => TourStatus::Available,
                'image' => $cdn.'5e88538d4fbaeabbf91ab714_Giant%20Ibis%20(2).avif',
                'meta_title' => 'Cambodia and Laos 2027',
                'meta_description' => 'Critically Endangered specialities with the Cambodian Laughingthrush extension.',
            ],
            [
                'name' => 'Vietnam',
                'slug' => 'vietnam-2027',
                'year' => 2027,
                'country' => 'Vietnam',
                'summary' => 'From south to north, and every bit in-between',
                'duration_days' => 21,
                'date_label' => '21st February - 13th March 2027 (21 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'5e8aba75ab1cf8ac36a888e9_Laughingthrush_Collared%2067.avif',
                'meta_title' => 'Vietnam 2027',
                'meta_description' => 'From south to north, and every bit in-between.',
            ],
            [
                'name' => 'Philippines: Endemic-bonanza',
                'slug' => 'philippines-endemic-bonanza-2027',
                'year' => 2027,
                'country' => 'Philippines',
                'summary' => 'Luzon, Mindanao and Palawan (can be combined with Intrepid Philippines)',
                'duration_days' => 21,
                'date_label' => '28th February - 20th March 2027 (21 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'5e8d337f030ea4e84f57346e_Steere%27s%20Pitta_PICOP%2C%20Philippines_05Feb17_4N3A9885.avif',
                'meta_title' => 'Philippines: Endemic-bonanza 2027',
                'meta_description' => 'Luzon, Mindanao and Palawan.',
            ],
            [
                'name' => 'Borneo: Sabah & Sarawak',
                'slug' => 'borneo-sabah-and-sarawak-2027',
                'year' => 2027,
                'country' => 'Malaysia',
                'summary' => 'Comprehensive tour combining Sabah with Sarawak highlands',
                'duration_days' => 23,
                'date_label' => '1st - 23rd May 2027 (23 days) / 4th - 26th September 2027 (23 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'642aa3eab24aeb54079951a2_Pitta_Bornean%20Banded%202.avif',
                'meta_title' => 'Borneo: Sabah & Sarawak 2027',
                'meta_description' => 'Comprehensive tour combining Sabah with the Sarawak highlands.',
            ],
            [
                'name' => 'India: Lesser Florican and Western Himalaya',
                'slug' => 'india-lesser-florican-and-western-himalaya-2027',
                'year' => 2027,
                'country' => 'India',
                'summary' => 'From Orange Bullfinch to displaying Lesser Florican',
                'duration_days' => 12,
                'date_label' => '22nd/24th July - 4th August 2027 (12 days)',
                'status' => TourStatus::Available,
                'image' => $cdn.'63058861534d3623290bfb52_Florican_Lesser.avif',
                'meta_title' => 'India: Lesser Florican and Western Himalaya 2027',
                'meta_description' => 'From Orange Bullfinch to displaying Lesser Florican.',
            ],
            [
                'name' => 'Sulawesi outer-islands Cruise',
                'slug' => 'sulawesi-outer-islands-cruise-2027',
                'year' => 2027,
                'country' => 'Indonesia',
                'summary' => 'Taliabu, Peleng, Wangi Wangi, Selayar and Togian',
                'duration_days' => 16,
                'date_label' => '18th October - 2nd November 2027 (16 days)',
                'status' => TourStatus::Available,
                'image' => $cdn.'691024f651f562527c0d217a_Myna_Bare-eyed%201.avif',
                'meta_title' => 'Sulawesi outer-islands Cruise 2027',
                'meta_description' => 'Taliabu, Peleng, Wangi Wangi, Selayar and Togian.',
            ],
            [
                'name' => 'Southern India and Andamans 2028',
                'slug' => 'southern-india-and-andamans-2028',
                'year' => 2028,
                'country' => 'India',
                'summary' => 'Western Ghats and Andaman & Nicobar endemics',
                'duration_days' => 14,
                'date_label' => '9th - 22nd January 2028 (14 days)',
                'status' => TourStatus::Full,
                'image' => $cdn.'5eeca26329b176706b577ae5_Bay%20Owl_Sri%20Lanka.avif',
                'meta_title' => 'Southern India and Andamans 2028',
                'meta_description' => 'Western Ghats and Andaman & Nicobar endemics.',
            ],
            [
                'name' => 'Japan Classic Winter 2028',
                'slug' => 'japan-classic-winter-2028',
                'year' => 2028,
                'country' => 'Japan',
                'summary' => "Cranes, eagles and Blakiston's Fish Owl",
                'duration_days' => 16,
                'date_label' => '15th - 30th January 2028 (16 days)',
                'status' => TourStatus::Available,
                'image' => $cdn.'65ccb01c35cbfaf65f21b5bd_Eagle_Steller%27s%20Sea%203.avif',
                'meta_title' => 'Japan Classic Winter 2028',
                'meta_description' => "Cranes, eagles and Blakiston's Fish Owl.",
            ],
            [
                'name' => 'Sumatra and Java, Indonesia 2028',
                'slug' => 'sumatra-and-java-indonesia-2028',
                'year' => 2028,
                'country' => 'Indonesia',
                'summary' => 'Endemic-filled tour combined with Sundaic treats',
                'duration_days' => 21,
                'date_label' => '2nd - 22nd July 2028 (21 days)',
                'status' => TourStatus::Available,
                'image' => $cdn.'6784854885cc7b8dbfbb80aa_Schneider%27s%20Pitta.avif',
                'meta_title' => 'Sumatra and Java, Indonesia 2028',
                'meta_description' => 'Endemic-filled tour combined with Sundaic treats.',
            ],
            [
                'name' => 'Banda Sea Liveaboard Cruise + Tanimbars',
                'slug' => 'banda-sea-liveaboard-cruise-tanimbars-2028',
                'year' => 2028,
                'country' => 'Indonesia',
                'summary' => 'Tanahjampea, Kalao, Alor, Wetar, Leti, Damar and Babar',
                'duration_days' => 19,
                'date_label' => '3rd - 21st October 2028 (19 days)',
                'status' => TourStatus::Provisional,
                'image' => $cdn.'66957dcf4f6c80d173dc3b1e_Ground%20Dove_Wetar.avif',
                'meta_title' => 'Banda Sea Liveaboard Cruise + Tanimbars 2028',
                'meta_description' => 'Tanahjampea, Kalao, Alor, Wetar, Leti, Damar and Babar.',
            ],
            [
                'name' => 'Eastern Polynesia',
                'slug' => 'eastern-polynesia',
                'year' => 2029,
                'country' => 'French Polynesia',
                'summary' => 'Tuamotu, Henderson, Pitcairn, Tahiti, Society and Marquesas',
                'duration_days' => null,
                'date_label' => 'Provisionally September - October, year TBC',
                'status' => TourStatus::Provisional,
                'image' => $cdn.'5e8aad57a6b2c128ecabeda7_Lorikeet_Kuhl%27s.avif',
                'meta_title' => 'Eastern Polynesia',
                'meta_description' => 'Tuamotu, Henderson, Pitcairn, Tahiti, Society and Marquesas.',
            ],
        ];
    }
}
