<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => ['ar' => 'نظام إدارة المبيعات', 'en' => 'Sales Management System'],
                'description' => ['ar' => 'نظام متكامل لإدارة المبيعات والمخازن', 'en' => 'An integrated system for sales and warehouse management'],
                'color' => 'green',
            ],
            [
                'title' => ['ar' => 'قوالب WordPress', 'en' => 'WordPress Themes'],
                'description' => ['ar' => 'قوالب احترافية للمدونات والمواقع', 'en' => 'Professional themes for blogs and websites'],
                'color' => 'emerald',
            ],
            [
                'title' => ['ar' => 'أنظمة إدارة الشركات', 'en' => 'ERP Management Systems'],
                'description' => ['ar' => 'حلول ERP مخصصة للشركات', 'en' => 'Custom ERP solutions for companies'],
                'color' => 'teal',
            ],
            [
                'title' => ['ar' => 'تطبيقات مخصصة', 'en' => 'Custom Applications'],
                'description' => ['ar' => 'تطبيقات مصممة خصيصاً لاحتياجاتك', 'en' => 'Applications designed specifically for your needs'],
                'color' => 'lime',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
