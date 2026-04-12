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
            // English Pages
            [
                'locale' => 'en',
                'title' => 'About FCPB',
                'slug' => 'about-fcpb',
                'content' => '<h1>About FCPB</h1><p>Welcome to the Film and Mass Communication Promotion Board, Madhesh Province. We are dedicated to promoting, regulating, and facilitating the film and mass communication sectors within the province.</p>',
                'is_active' => true,
            ],
            [
                'locale' => 'en',
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h1>Contact Us</h1><p>Get in touch with us for inquiries regarding film permits, distribution licenses, or mass communication regulation in Madhesh Province.</p><p>Email: contact@fcpbportal.com</p><p>Location: Janakpurdham, Madhesh Province, Nepal</p>',
                'is_active' => true,
            ],
            [
                'locale' => 'en',
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us. We collect personal information during registration to provide you with film permits and mass communication services.</p>',
                'is_active' => true,
            ],
            [
                'locale' => 'en',
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h1>Terms of Service</h1><p>By accessing or using the FCPB online portal, you agree to comply with and be bound by these Terms of Service.</p>',
                'is_active' => true,
            ],

            // Nepali Pages
            [
                'locale' => 'ne',
                'title' => 'हाम्रो बारेमा',
                'slug' => 'about-fcpb',
                'content' => '<h1>चलचित्र तथा लोकसञ्चार प्रवर्द्धन बोर्डको बारेमा</h1><p>चलचित्र तथा लोकसञ्चार प्रवर्द्धन बोर्ड, मधेश प्रदेशमा तपाईंलाई स्वागत छ। हामी प्रदेशभित्र चलचित्र र लोकसञ्चार क्षेत्रको प्रवर्द्धन, नियमन र सहजीकरणका लागि समर्पित छौं।</p>',
                'is_active' => true,
            ],
            [
                'locale' => 'ne',
                'title' => 'सम्पर्क गर्नुहोस्',
                'slug' => 'contact-us',
                'content' => '<h1>सम्पर्क गर्नुहोस्</h1><p>मधेश प्रदेशमा चलचित्र अनुमति, वितरण इजाजतपत्र, वा लोकसञ्चार नियमन सम्बन्धी सोधपुछका लागि हामीलाई सम्पर्क गर्नुहोस्।</p><p>इमेल: contact@fcpbportal.com</p><p>स्थान: जनकपुरधाम, मधेश प्रदेश, नेपाल</p>',
                'is_active' => true,
            ],
            [
                'locale' => 'ne',
                'title' => 'गोपनीयता नीति',
                'slug' => 'privacy-policy',
                'content' => '<h1>गोपनीयता नीति</h1><p>तपाईंको गोपनीयता हाम्रो लागि महत्त्वपूर्ण छ। हामी तपाईंलाई चलचित्र अनुमति र लोकसञ्चार सेवाहरू प्रदान गर्न दर्ताको क्रममा व्यक्तिगत जानकारी सङ्कलन गर्छौं।</p>',
                'is_active' => true,
            ],
            [
                'locale' => 'ne',
                'title' => 'सेवाका सर्तहरू',
                'slug' => 'terms-of-service',
                'content' => '<h1>सेवाका सर्तहरू</h1><p>चलचित्र तथा लोकसञ्चार प्रवर्द्धन बोर्डको अनलाइन पोर्टल प्रयोग गरेर, तपाईं यी सेवाका सर्तहरू पालना गर्न र यसमा बाँधिन सहमत हुनुहुन्छ।</p>',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug'], 'locale' => $page['locale']],
                $page
            );
        }
    }
}
