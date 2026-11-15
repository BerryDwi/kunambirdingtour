<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

class LeaderSeeder extends Seeder
{
    /**
     * Seed the tour leaders replicated from the public leaders page.
     */
    public function run(): void
    {
        foreach ($this->leaders() as $index => $leader) {
            Leader::updateOrCreate(
                ['slug' => $leader['slug']],
                $leader + [
                    'is_published' => true,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }

    /**
     * The leaders replicated from the public leaders page.
     *
     * @return array<int, array<string, mixed>>
     */
    private function leaders(): array
    {
        $cdn = 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/';

        return [
            [
                'name' => 'James Eaton',
                'slug' => 'james-eaton',
                'region' => 'Throughout the region',
                'badge_style' => 'success',
                'bio' => "James's teenage years eventually led him east, thinking nothing of skipping college for a long trip with Rob to India! He has built an intimate knowledge of the identification, vocalisations and behaviour of the birds throughout the whole continent. This has resulted in the discovery of several undescribed species in Indonesia in the field, several other cryptic species at his desk resulting from fieldwork, co-authored four new species descriptions, as well as numerous rediscoveries during his visits to over 80 islands within the archipelago. The culmination of his field-time has resulted in the publication of over 100 manuscripts and articles, and lead-author of the <em>Birds of the Indonesian Archipelago</em>.\n\nJames has a PhD, having studied taxonomically cryptic species and their conservation status. A keen conservationist, with a particular interest in trying to put an end to the bird trade through surveys and research, and a member of the IUCN Asian Songbird Trade, Pigeon & Doves, and Hornbill specialist groups. On top of that, he is an eBird reviewer for Indonesia and Malaysia, and part of the AviList taxonomic committee for Tropical Asia.",
                'photo' => $cdn.'6123ab197c07825e9afca2de_James%202.avif',
            ],
            [
                'name' => 'Rob Hutchinson',
                'slug' => 'rob-hutchinson',
                'region' => 'Throughout the region',
                'badge_style' => 'success',
                'bio' => "Rob began birding almost as soon as he could lift a pair of binoculars and foreign travel soon developed this into a passion for world birding, with a special interest in the birds of the Oriental region. Since graduating with a BSc in genetics he has travelled throughout the region, visiting many remote areas in search of the region's very rarest birds.\n\nRob is an accomplished photographer and keen sound recordist who has authored many scientific papers on the vocalisations, distribution and taxonomy of the region's birds including several elevating little-known forms to species rank. His main interest is his adopted country of the Philippines where he has seen most extant species and co-authored <em>A Naturalists guide to the birds of the Philippines</em>. His travels across the region have netted more than 2,900 species - likely more than anyone else.",
                'photo' => $cdn.'5e8bf1729c0c133f906abcf8_Rob%20Hutchinson.avif',
            ],
            [
                'name' => 'Bob Natural',
                'slug' => 'bob-natural',
                'region' => 'Office Manager',
                'badge_style' => 'info',
                'bio' => "Bob grew up on the island of Masbate in the Bicol Region of the Philippines where he first developed a fascination for the natural world. After earning his degree in Biology at Bicol University he spent several years working with environmental NGOs in the country, contributing to biodiversity conservation on Mindoro and the Polillo Islands.\n\nIn recent years he has continued his work as a wildlife biologist focusing on migratory shorebirds and Philippine endemics. These days he lives in Batangas from where he works remotely to manage the Birdtour Asia office - he will frequently be your first point of contact with us, and help with any questions you have regarding any aspect of our tours.",
                'photo' => $cdn.'69c63d2fa5f7b7fa4d98d5eb_Bob%20Natural.avif',
                'email' => 'office@birdtourasia.com',
            ],
            [
                'name' => 'Wilbur Goh',
                'slug' => 'wilbur-goh',
                'region' => 'China, Southeast Asia & Papua',
                'badge_style' => 'success',
                'bio' => "Wilbur is a Malaysian who started birding in his early teens, an obsession which has blossomed into a lifelong love affair with the region's birds. Having travelled the length and breadth of the country for birding, Wilbur knows intimately the habits and calls of Malaysian birds. Birding in other countries throughout Asia has broadened his experience, and he is now one of the more experienced guides in Papua and eastern Indonesia. His easy going, relaxed attitude, even during intense birding days, makes him an extremely popular guide.",
                'photo' => $cdn.'5e8c2ba0460eb4f7d7523f76_Wilbur.avif',
            ],
            [
                'name' => 'Mike Nelson',
                'slug' => 'mike-nelson',
                'region' => 'Throughout the region',
                'badge_style' => 'success',
                'bio' => 'Mike has been a birder since he was six, when he became fascinated with the birds in his English garden. Having lived in and travelled to over 40 countries, he is an experienced world birder and an avid sound recordist who has logged over 12,000 sound recordings. Working as a full-time guide for Birdtour Asia was a natural progression to share his knowledge and enthusiasm on tours throughout our region.',
                'photo' => $cdn.'5e8bf171999957f708b325c8_Mike%20Nelson.avif',
            ],
            [
                'name' => 'Shashank Dalvi',
                'slug' => 'shashank-dalvi',
                'region' => 'India',
                'badge_style' => 'success',
                'bio' => 'Shashank is a researcher and conservationist from India with more than 25 years of field experience. His work led to the discovery of the new bird species Himalayan Forest Thrush, as well as exposing the mass-scale hunting of Amur Falcons in Nagaland. In 2015, Shashank completed a Big Year in India with 1,128 species seen, and he developed the Vannya mobile app used by over 50,000 birdwatchers. He is also the only birder to have spent time on all main Nicobar islands during recent research projects.',
                'photo' => $cdn.'5e7da8430e1cdb1c41ae30f6_Shashank.avif',
            ],
            [
                'name' => 'Elan James',
                'slug' => 'elan-james',
                'region' => 'China',
                'badge_style' => 'success',
                'bio' => 'Elan hails from Jiangxi Province and graduated in 2022 from Nanchang University. He is an up-and-coming talent in the China bird guiding community, having already seen more than 700 species in China. Incredibly sharp in the field, keen on identification issues, his infectious enthusiasm and service-oriented personality make him a firm favourite with everyone he guides.',
                'photo' => $cdn.'66b1ba4c3f0a0f62d7d97c40_Elan.avif',
            ],
            [
                'name' => 'Boas Emmanuel',
                'slug' => 'boas-emmanuel',
                'region' => 'Indonesia',
                'badge_style' => 'success',
                'bio' => 'Boas was born in Jakarta and developed a passion for wildlife at a young age. He led his first birding tour in 2010 and now guides across much of the Indonesian archipelago, especially photographic tours targeting endemic pittas. Boas was also part of the Black-browed Babbler survey team that rediscovered the species in Kalimantan in 2021 after it had been lost for over 170 years.',
                'photo' => $cdn.'6469951d95b1965bd90d7491_Boas.avif',
            ],
            [
                'name' => 'Khaleb Yordan',
                'slug' => 'khaleb-yordan',
                'region' => 'Indonesia',
                'badge_style' => 'success',
                'bio' => 'Born and raised in Jakarta, Khaleb has gained an intimate knowledge of the endemics and specialities of Java, Bali, Sumatra, Sulawesi, Moluccas and Papua. Khaleb is the perfect guide for custom tours throughout Indonesia, adept at dealing with complex remote itineraries and finding the toughest island specialities.',
                'photo' => $cdn.'5e9073ac5a0e49565a208bff_Khaleb.avif',
            ],
            [
                'name' => 'Wichyanan Limparungpatthanakij (Jay)',
                'slug' => 'wichyanan-limparungpatthanakij',
                'region' => 'Thailand',
                'badge_style' => 'success',
                'bio' => 'Having seen over 940 species in Thailand, Jay co-authored the <em>Birds of Thailand</em> in 2018 with Uthai Treesucon. He is the regional eBird reviewer for Thailand and a member of both Thai and Philippine Rarities Committees. With over a decade of guiding experience, there really is no one better to guide you through Thailand.',
                'photo' => $cdn.'640978930f1b4f1e88dbed18_Jay.avif',
            ],
            [
                'name' => 'Sumaraja',
                'slug' => 'sumaraja',
                'region' => 'Indonesia',
                'badge_style' => 'success',
                'bio' => "'Raja is a much loved face on all of our Sumatra, Java, Lesser Sundas and Banda Sea tours. He has co-led over 60 tours with us since 2007. Prior to guiding for Birdtour Asia, he was Ben King's right-hand man, including successfully finding Wetar Ground Dove way back in 2008.",
                'photo' => $cdn.'6336d4c59532fce156f69e65_Sumaraja.avif',
            ],
            [
                'name' => 'Otani Chikara',
                'slug' => 'otani-chikara',
                'region' => 'Japan',
                'badge_style' => 'success',
                'bio' => "After graduating from the University of Tokyo, Otani has worked as a researcher and bird guide for nearly 40 years. His passion led him across the world in pursuit of birds, culminating in him authoring Lynx's <em>Birds of Japan</em> field guide.",
                'photo' => $cdn.'64f15124ed886d13a61500d6_Otani.avif',
            ],
            [
                'name' => 'Tim Dinh',
                'slug' => 'tim-dinh',
                'region' => 'Vietnam',
                'badge_style' => 'success',
                'bio' => 'Tim is one of the most experienced and sought-after birdwatching guides in Vietnam. A tour with Tim means having special access to feeding stations, allowing intimate views of Vietnamese endemics like laughingthrushes and babblers.',
                'photo' => $cdn.'65087383e265235e2b71ca01_Tim.avif',
            ],
            [
                'name' => 'Martin Kennewell',
                'slug' => 'martin-kennewell',
                'region' => 'Eastern Palaearctic',
                'badge_style' => 'success',
                'bio' => 'Martin has amassed well over 8,000 species worldwide. Based in Asia for over 20 years, mostly in Singapore, he leads Birdtour Asia tours with a focus on the Eastern Palearctic including the Middle East, Mongolia, China and Japan.',
                'photo' => $cdn.'649596bac7f17d4112688d44_Martin.avif',
            ],
            [
                'name' => 'Prof. Frank Rheindt',
                'slug' => 'prof-frank-rheindt',
                'region' => 'Guest Co-Leader (Banda Sea 2028)',
                'badge_style' => 'warning',
                'bio' => 'Head of the Avian Evolution Lab at the National University of Singapore, Frank has described roughly a dozen new bird species (including Alor Myzomela) and is Chair of the AviList Taxonomic Committee and co-author of the <em>Birds of the Indonesian Archipelago</em> with James.',
                'photo' => $cdn.'6ac46a79ca29c5fa58ea2b39_frank.jpg',
            ],
        ];
    }
}
