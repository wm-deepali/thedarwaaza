<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        $brand = 'The Darwaaza';
        $base  = rtrim(config('app.url'), '/');

        $defaults = [
            'robots'             => 'index, follow',
            'og_type'            => 'website',
            'twitter_card'       => 'summary_large_image',
            'in_sitemap'         => true,
            'sitemap_priority'   => 0.5,
            'sitemap_changefreq' => 'monthly',
            'is_active'          => true,
        ];

        // page_key MUST match the front route names in routes/web.php
        $pages = [
            // ---------- Main ----------
            [
                'page_key' => 'home', 'page_name' => 'Home', 'page_group' => 'Main', 'slug' => '/',
                'meta_title' => "$brand | Official Website",
                'meta_description' => "Welcome to $brand. Explore our products, our strengths and get in touch with us for enquiries.",
                'meta_keywords' => 'the darwaaza, darwaaza',
                'sitemap_priority' => 1.0, 'sitemap_changefreq' => 'weekly',
                'schema_markup' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        ['@type' => 'Organization', 'name' => $brand, 'url' => $base],
                        ['@type' => 'WebSite', 'name' => $brand, 'url' => $base],
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_key' => 'about', 'page_name' => 'About Us', 'page_group' => 'Main', 'slug' => '/about',
                'meta_title' => "About Us | $brand",
                'meta_description' => "Learn about $brand, our story, our values and what makes us different.",
                'sitemap_priority' => 0.7,
            ],
            [
                'page_key' => 'strength', 'page_name' => 'Our Strength', 'page_group' => 'Main', 'slug' => '/strength',
                'meta_title' => "Our Strength | $brand",
                'meta_description' => "Discover the strengths, capabilities and quality standards behind $brand.",
                'sitemap_priority' => 0.6,
            ],
            [
                'page_key' => 'enquiry', 'page_name' => 'Enquiry', 'page_group' => 'Main', 'slug' => '/enquiry',
                'meta_title' => "Enquiry | $brand",
                'meta_description' => "Send us your enquiry and the team at $brand will get back to you shortly.",
                'sitemap_priority' => 0.7,
            ],
            [
                'page_key' => 'contact', 'page_name' => 'Contact Us', 'page_group' => 'Main', 'slug' => '/contact',
                'meta_title' => "Contact Us | $brand",
                'meta_description' => "Get in touch with $brand. Find our address, phone number, email and location map.",
                'sitemap_priority' => 0.7,
            ],

            // ---------- Shop (fallback only: category pages override per record) ----------
            [
                'page_key' => 'category.show', 'page_name' => 'Category Detail (fallback)', 'page_group' => 'Shop', 'slug' => '/category/{slug}',
                'meta_title' => "Our Collection | $brand",
                'meta_description' => "Explore this collection at $brand.",
                'in_sitemap' => false,
            ],
        ];

        foreach ($pages as $page) {
            SeoPage::updateOrCreate(
                ['page_key' => $page['page_key']],
                $page + $defaults
            );
        }

        // Remove leftover rows from the old site (saree / cart / checkout / blog etc.)
        SeoPage::whereNotIn('page_key', array_column($pages, 'page_key'))->delete();
    }
}