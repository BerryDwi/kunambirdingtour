<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->setValue('home_announcement_body', '2027: we have spaces on Laos and Cambodia in March, Lesser Florican & Western Himalaya tour in July and Sulawesi islands Cruise.');

        $this->setValue('home_about_body', implode("\n\n", [
            'Kunam Birding Tours are the specialists in birding tours, offering the best in organised and tailor-made custom tours throughout the region for 20 years. We offer you the best possible bird-tour experience through a combination of the most experienced and knowledgeable leaders in the region, small group sizes, a friendly and relaxed atmosphere, and of course some of the finest birding in the world.',
            'Our tours cover a huge swathe from Saudi Arabia and Socotra in the west, to the Kamchatka coastline in the north, and as far east as West Papua in New Guinea. We carefully plan each tour to optimise the birding opportunities at each site visited, concentrating on the most enigmatic, localised and hard to find species. By allowing time for comprehensive coverage we will give ourselves the best realistic chance of locating these speciality birds of the region.',
            'Our scheduled tours are equalled in popularity by our custom tours, with itineraries designed with the intimate knowledge of our Kunam Birding Tours team to match your needs for any bird targets, mammals, culture or cuisine.',
            'Please visit our tours page for our 2026-2028 scheduled departures or contact us by e-mail or WhatsApp if you would like us to organise one of our popular custom tours. Our 2029 tour calendar will be published in December 2026.',
        ]));

        $this->setValue('home_award_text', 'We take great pride in the positive feedback and testimonials from our past participants: we were the only tour company to score 100% in every category in a Birdwatch Magazine survey, as well as placing number one by Stride (www.stridetravel.com) in their Top 10 Birdwatching tour operators.');

        $this->setValue('home_facebook_text', 'Our Facebook page has regular updates from the field and tour photo albums, along with instant messaging support.');

        Cache::forget('settings.values');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->setValue('home_announcement_body', '<strong>2027:</strong> we have spaces on Laos and Cambodia in March, Lesser Florican &amp; Western Himalaya tour in July and Sulawesi islands Cruise.');

        $this->setValue('home_about_body', implode("\n\n", [
            '<strong>Kunam Birding Tours</strong> are the specialists in birding tours, offering the best in organised and tailor-made custom tours throughout the region for 20 years. We offer you the best possible bird-tour experience through a combination of the most experienced and knowledgeable leaders in the region, small group sizes, a friendly and relaxed atmosphere, and of course some of the finest birding in the world.',
            'Our tours cover a huge swathe from Saudi Arabia and Socotra in the west, to the Kamchatka coastline in the north, and as far east as West Papua in New Guinea. We carefully plan each tour to optimise the birding opportunities at each site visited, concentrating on the most enigmatic, localised and hard to find species. By allowing time for comprehensive coverage we will give ourselves the best realistic chance of locating these speciality birds of the region.',
            'Our scheduled tours are equalled in popularity by our custom tours, with itineraries designed with the intimate knowledge of our Kunam Birding Tours team to match your needs for any bird targets, mammals, culture or cuisine.',
            'Please visit our <a href="/tours" class="fw-bold text-success text-decoration-none">tours page</a> for our 2026-2028 scheduled departures or contact us via <a href="mailto:info@birdtourasia.com?subject=Tour%20enquiry" class="fw-bold text-success text-decoration-none">e-mail</a> or <a href="tel:+60142234220" class="fw-bold text-success text-decoration-none">WhatsApp</a> if you would like us to organise one of our popular custom tours. Our 2029 tour calendar will be published in December 2026.',
        ]));

        $this->setValue('home_award_text', 'We take great pride in the positive feedback and testimonials from our past participants: we were the only tour company to score <strong>100% in every category</strong> in a <em>Birdwatch Magazine</em> survey, as well as placing <strong>number one</strong> by Stride (<a href="https://www.stridetravel.com/" target="_blank" rel="noopener" class="text-success text-decoration-none">www.stridetravel.com</a>) in their Top 10 Birdwatching tour operators.');

        $this->setValue('home_facebook_text', 'Our <a href="https://www.facebook.com/birdtourasia" target="_blank" rel="noopener" class="text-success fw-bold text-decoration-none">Facebook page</a> has regular updates from the field and tour photo albums, along with instant messaging support.');

        Cache::forget('settings.values');
    }

    /**
     * Replace a setting value by key.
     */
    private function setValue(string $key, string $value): void
    {
        DB::table('settings')->where('key', $key)->update(['value' => $value]);
    }
};
