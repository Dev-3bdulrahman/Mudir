<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioItem;

class PortfolioItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => ['ar' => 'نظام المحاسبة السنايبر', 'en' => 'Sniper Accounting System'],
                'description' => ['ar' => 'نظام محاسبي متكامل لإدارة المبيعات', 'en' => 'An integrated accounting system for sales management'],
                'year' => '2020',
                'color' => 'orange',
            ],
            [
                'title' => ['ar' => 'مواقع الشركات', 'en' => 'Corporate Websites'],
                'description' => ['ar' => 'تصميم وبرمجة مواقع لشركات ورجال أعمال', 'en' => 'Design and programming of websites for companies and businessmen'],
                'year' => '2021',
                'color' => 'red',
            ],
            [
                'title' => ['ar' => 'قوالب بلوجر', 'en' => 'Blogger Templates'],
                'description' => ['ar' => 'قوالب احترافية على منصة خمسات', 'en' => 'Professional templates on the Khamsat platform'],
                'year' => '2019',
                'color' => 'pink',
            ],
            [
                'title' => ['ar' => 'أنظمة إدارية', 'en' => 'Administrative Systems'],
                'description' => ['ar' => 'أنظمة مخصصة لإدارة العمليات', 'en' => 'Custom systems for operations management'],
                'year' => '2022',
                'color' => 'blue',
            ],
        ];

        foreach ($items as $item) {
            PortfolioItem::create($item);
        }
    }
}
