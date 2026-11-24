<?php

namespace App\Enums;

/**
 * Public pages that own their own hero slides and hero text settings.
 */
enum SitePage: string
{
    case Home = 'home';
    case Tours = 'tours';
    case CustomTours = 'custom-tours';
    case Reports = 'reports';
    case Leaders = 'leaders';
    case Booking = 'booking';
    case Contact = 'contact';
    case Terms = 'terms';

    /**
     * All supported page values.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Human readable label used in admin screens.
     */
    public function label(): string
    {
        return match ($this) {
            self::Home => 'Home Page',
            self::Tours => 'Tours Page',
            self::CustomTours => 'Custom Tours Page',
            self::Reports => 'Tour Reports Page',
            self::Leaders => 'Leaders Page',
            self::Booking => 'Booking Page',
            self::Contact => 'Contact Page',
            self::Terms => 'Terms Page',
        };
    }

    /**
     * Name of the public route for the page.
     */
    public function publicRoute(): string
    {
        return match ($this) {
            self::Home => 'home',
            self::Tours => 'tours',
            self::CustomTours => 'custom-tours',
            self::Reports => 'tour-reports',
            self::Leaders => 'leaders',
            self::Booking => 'booking',
            self::Contact => 'contact',
            self::Terms => 'terms',
        };
    }

    /**
     * Default hero text for the page, keyed by setting key.
     *
     * @return array<string, string>
     */
    public function heroSettingDefaults(): array
    {
        return match ($this) {
            self::Home => [
                'home_announcement_badge' => 'Field Update',
                'home_announcement_date' => '14/10 Announcement',
                'home_announcement_title' => 'Latest news 14/10',
                'home_announcement_body' => '2027: we have spaces on Laos and Cambodia in March, Lesser Florican & Western Himalaya tour in July and Sulawesi islands Cruise.',
                'home_announcement_cta_label' => 'View 2027 Departures',
                'home_announcement_cta_url' => '/tours',
            ],
            self::Tours => [
                'tours_hero_badge' => '',
                'tours_hero_date' => '',
                'tours_hero_title' => 'Scheduled Tours',
                'tours_hero_text' => '2027 - 2028 Scheduled Tour Calendar',
                'tours_hero_cta_label' => '',
                'tours_hero_cta_url' => '',
            ],
            self::CustomTours => [
                'custom-tours_hero_badge' => 'Tailormade Itineraries',
                'custom-tours_hero_date' => '',
                'custom-tours_hero_title' => 'Custom Tours',
                'custom-tours_hero_text' => 'Tailormade, custom-designed birding tours available throughout the continent for individuals and private groups.',
                'custom-tours_hero_cta_label' => '',
                'custom-tours_hero_cta_url' => '',
            ],
            self::Reports => [
                'reports_hero_badge' => 'Trip Archives',
                'reports_hero_date' => '',
                'reports_hero_title' => 'Tour Reports',
                'reports_hero_text' => 'Click below for latest, or specific country reports. Downloadable PDF reports and species checklists from 2005 to date.',
                'reports_hero_cta_label' => '',
                'reports_hero_cta_url' => '',
            ],
            self::Leaders => [
                'leaders_hero_badge' => 'Our Team',
                'leaders_hero_date' => '',
                'leaders_hero_title' => 'Tour Leaders',
                'leaders_hero_text' => 'Get to know more about our family, all of whom are based in the region and lead both our scheduled and custom tours.',
                'leaders_hero_cta_label' => '',
                'leaders_hero_cta_url' => '',
            ],
            self::Booking => [
                'booking_hero_badge' => 'Reservations & Booking',
                'booking_hero_date' => '2027 – 2028 Tours',
                'booking_hero_title' => 'Booking with Kunam Birding Tours',
                'booking_hero_text' => 'A clear, simple, and transparent booking process for both our scheduled departures and tailor-made custom tours.',
                'booking_hero_cta_label' => 'Booking FAQs ↓',
                'booking_hero_cta_url' => '#booking-faq',
                'booking_hero_secondary_cta_label' => 'View Tours →',
                'booking_hero_secondary_cta_url' => '/tours',
            ],
            self::Contact => [
                'contact_hero_badge' => 'Get In Touch',
                'contact_hero_date' => 'Direct Assistance',
                'contact_hero_title' => 'Contact Kunam Birding Tours',
                'contact_hero_text' => 'Reach our tour leaders in the field or office manager directly via Email, WhatsApp, or through our contact form.',
                'contact_hero_cta_label' => 'Contact Details ↓',
                'contact_hero_cta_url' => '#contact-channels',
                'contact_hero_secondary_cta_label' => 'Send a Message →',
                'contact_hero_secondary_cta_url' => '#contact-form-section',
            ],
            self::Terms => [
                'terms_hero_badge' => 'Legal & Policy',
                'terms_hero_date' => 'Booking Conditions',
                'terms_hero_title' => 'Terms and Conditions',
                'terms_hero_text' => 'Transparent contractual policies, small-group operational standards, and 100% financial insolvency protection under UK & EU Package Travel Regulations.',
                'terms_hero_cta_label' => 'Financial Security ↓',
                'terms_hero_cta_url' => '#financial-security',
                'terms_hero_secondary_cta_label' => 'Payment Terms',
                'terms_hero_secondary_cta_url' => '#payment',
            ],
        };
    }
};
