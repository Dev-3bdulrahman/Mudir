<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => ['ar' => 'عبدالرحمن محيسن', 'en' => 'Abdulrahman Mohisen'],
            'job_title' => ['ar' => 'مطور برمجيات متكامل', 'en' => 'Full Stack Developer'],
            'site_description' => [
                'ar' => 'متخصص في تطوير تطبيقات الويب، إدارة السيرفرات، وبناء سير عمل أوتوماتيكي متكامل.',
                'en' => 'Specializing in Web Applications, Server Management, and Building Automated Workflows.'
            ],
            'contact_email' => 'me@3bdulrahman.com',
            'contact_phone' => '+201020904386',
            'whatsapp' => '+201020904386',
            'facebook' => 'https://www.facebook.com/Dev.3bdulrahman/',
            'twitter' => 'https://x.com/dev_3bdulrahman',
            'instagram' => 'https://instagram.com/dev_3bdulrahman', // Inferred from Twitter handle if not found, but I'll use Twitter/FB/LinkedIn primarily
            'linkedin' => 'https://www.linkedin.com/in/3bdulrahman',
            'github' => 'https://github.com/Dev-3bdulrahman',
            'seo_title' => ['ar' => 'عبدالرحمن محيسن | مطور برمجيات متكامل', 'en' => 'Abdulrahman Mohisen | Full Stack Developer'],
            'seo_description' => [
                'ar' => 'الموقع الرسمي للمهندس عبدالرحمن محيسن، متخصص في تطبيقات الويب وإدارة السيرفرات والأتمتة.',
                'en' => 'Official website of Abdulrahman Mohisen, specialized in Web Applications, Server Management, and Automation.'
            ],
            'seo_keywords' => ['ar' => 'مطور ويب, إدارة سيرفرات, أتمتة, عبدالرحمن محيسن, Web Developer', 'en' => 'Web Developer, Server Management, Automation, Abdulrahman Mohisen'],
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
