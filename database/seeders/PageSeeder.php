<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About FCPB',
                'slug' => 'about-fcpb',
                'content' => '<h1>About FCPB</h1><p>Welcome to FCPB. This is where we tell our story.</p>',
                'is_active' => true,
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h1>Contact Us</h1><p>Get in touch with us at contact@fcpb.com</p>',
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us.</p>',
                'is_active' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h1>Terms of Service</h1><p>Please read our terms carefully.</p>',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
