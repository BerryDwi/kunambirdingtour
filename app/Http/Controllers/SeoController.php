<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Render the public XML sitemap.
     */
    public function sitemap(): Response
    {
        $urls = [
            ['url' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['url' => route('tours'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => route('custom-tours'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => route('tour-reports'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => route('leaders'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['url' => route('booking'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['url' => route('contact'), 'changefreq' => 'yearly', 'priority' => '0.6'],
            ['url' => route('terms'), 'changefreq' => 'yearly', 'priority' => '0.5'],
        ];

        foreach (Tour::query()->published()->get() as $tour) {
            $urls[] = [
                'url' => route('tours.show', $tour),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Render the robots.txt file with the sitemap location.
     */
    public function robots(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
            '',
        ]);

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
