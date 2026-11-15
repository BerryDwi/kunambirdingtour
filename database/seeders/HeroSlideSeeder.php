<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    /**
     * Seed the hero slides shown on each public page.
     */
    public function run(): void
    {
        foreach ($this->slides() as $page => $slides) {
            foreach ($slides as $index => $slide) {
                HeroSlide::updateOrCreate(
                    ['page' => $page, 'alt' => $slide['alt']],
                    [
                        'image' => $slide['image'],
                        'title' => $slide['title'] ?? null,
                        'text' => $slide['text'] ?? null,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ],
                );
            }
        }
    }

    /**
     * The slide images replicated from the existing public pages.
     *
     * @return array<string, array<int, array{image: string, alt: string, title?: string, text?: string}>>
     */
    private function slides(): array
    {
        $cdn = 'https://cdn.prod.website-files.com/5df5bf90b0ebe7d8cd4333fb/';

        return [
            'home' => [
                ['image' => $cdn.'6828344570093a50ccb5faa6_Plover_Oriental.avif', 'alt' => 'Oriental Plover'],
                ['image' => $cdn.'666d2a197b96efb3471efbb8_Tragopan_Western_web.avif', 'alt' => 'Western Tragopan'],
                ['image' => $cdn.'642aa3eab24aeb54079951a2_Pitta_Bornean%20Banded%202.avif', 'alt' => 'Bornean Banded Pitta'],
                ['image' => $cdn.'666949389ab4af61d98dec6a_Bunting_Red-headed%207.avif', 'alt' => 'Red-headed Bunting'],
            ],
            'tours' => [
                [
                    'image' => $cdn.'6828344570093a50ccb5faa6_Plover_Oriental.avif',
                    'alt' => 'Oriental Plover',
                    'title' => 'Scheduled Tours',
                    'text' => '2027 - 2028 Scheduled Tour Calendar',
                ],
            ],
            'custom-tours' => [
                ['image' => $cdn.'5e821abb177d95ae356c759e_Vogelkop%20Bird-of-paradise.avif', 'alt' => 'Vogelkop Bird-of-paradise'],
                ['image' => $cdn.'5e8ac962ab1cf8ac7ea8d5c1_Painted%20Tiger%20Parrot.avif', 'alt' => 'Painted Tiger Parrot'],
                ['image' => $cdn.'5e897b584fbaea57dc200816_Yellow-eyed%20Pigeon%20(40).avif', 'alt' => 'Yellow-eyed Pigeon'],
                ['image' => $cdn.'5e88864ecce5fb81e3a8c636_Nuthatch_Beautiful%20104.avif', 'alt' => 'Beautiful Nuthatch'],
                ['image' => $cdn.'5e86ced086c3b0ec93ebe3d9_Longspur_Lapland%207.avif', 'alt' => 'Lapland Longspur'],
            ],
            'reports' => [
                ['image' => $cdn.'5e8188735836db6bfcc1c994_Kamchatka%20Leaf%20Warbler.avif', 'alt' => 'Kamchatka Leaf Warbler'],
                ['image' => $cdn.'5e81924d957e0a0d1834103a_Tufted%20Puffin.avif', 'alt' => 'Tufted Puffin'],
                ['image' => $cdn.'5e88b96158eddea5f46f8d54_Harrier_Pied%201.avif', 'alt' => 'Pied Harrier'],
                ['image' => $cdn.'5e88865ecce5fbca75a8c736_Wren%20Babbler_Long-billed%2011.avif', 'alt' => 'Long-billed Wren-Babbler'],
                ['image' => $cdn.'5e88b962ab1cf870309e6230_Lark_Sand%202.avif', 'alt' => 'Sand Lark'],
            ],
            'leaders' => [
                ['image' => $cdn."67848ee957c5ce777888bf74_Bunting_Jankowski's.avif", 'alt' => "Jankowski's Bunting"],
                ['image' => $cdn.'5e8458cde22116618e36c237_Parakeet_Himalayan%2012.avif', 'alt' => 'Himalayan Parakeet'],
                ['image' => $cdn.'67848596e356d51baca99396_Bunting_Grey-necked.avif', 'alt' => 'Grey-necked Bunting'],
                ['image' => $cdn.'5e8ac94306f670981ed7518e_Twelve-wired%20BOP.avif', 'alt' => 'Twelve-wired Bird-of-paradise'],
                ['image' => $cdn.'5e8abc7ba6b2c13ae8ac232b_Tesia_Grey-bellied%2025.avif', 'alt' => 'Grey-bellied Tesia'],
            ],
            'booking' => [
                ['image' => $cdn.'666d2a197b96efb3471efbb8_Tragopan_Western_web.avif', 'alt' => 'Western Tragopan'],
                ['image' => $cdn.'5e821abb177d95ae356c759e_Vogelkop%20Bird-of-paradise.avif', 'alt' => 'Vogelkop Bird-of-paradise'],
                ['image' => $cdn.'5e8ac962ab1cf8ac7ea8d5c1_Painted%20Tiger%20Parrot.avif', 'alt' => 'Painted Tiger Parrot'],
                ['image' => $cdn.'642aa3eab24aeb54079951a2_Pitta_Bornean%20Banded%202.avif', 'alt' => 'Bornean Banded Pitta'],
            ],
            'contact' => [
                ['image' => $cdn.'6828344570093a50ccb5faa6_Plover_Oriental.avif', 'alt' => 'Oriental Plover'],
                ['image' => $cdn.'5e8ac962ab1cf8ac7ea8d5c1_Painted%20Tiger%20Parrot.avif', 'alt' => 'Painted Tiger Parrot'],
                ['image' => $cdn.'5e821abb177d95ae356c759e_Vogelkop%20Bird-of-paradise.avif', 'alt' => 'Vogelkop Bird-of-paradise'],
            ],
            'terms' => [
                ['image' => $cdn.'666d2a197b96efb3471efbb8_Tragopan_Western_web.avif', 'alt' => 'Western Tragopan'],
                ['image' => $cdn.'5e897b584fbaea57dc200816_Yellow-eyed%20Pigeon%20(40).avif', 'alt' => 'Yellow-eyed Pigeon'],
                ['image' => $cdn.'5e88864ecce5fb81e3a8c636_Nuthatch_Beautiful%20104.avif', 'alt' => 'Beautiful Nuthatch'],
            ],
        ];
    }
}
