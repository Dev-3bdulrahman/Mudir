<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        /* OLD SERVICES - COMMENTED OUT
        $services = [
            [
                'title' => ['ar' => 'تطوير تطبيقات الويب', 'en' => 'Web Application Development'],
                'description' => ['ar' => 'تطبيقات ويب حديثة ومتجاوبة باستخدام أحدث التقنيات', 'en' => 'Modern and responsive web applications using the latest technologies'],
                'color' => 'purple',
                'icon' => 'globe'
            ],
            [
                'title' => ['ar' => 'تطوير Full Stack', 'en' => 'Full Stack Development'],
                'description' => ['ar' => 'حلول متكاملة من قواعد البيانات حتى الواجهة الأمامية', 'en' => 'Integrated solutions from databases to the front-end'],
                'color' => 'blue',
                'icon' => 'layers'
            ],
            [
                'title' => ['ar' => 'إدارة الخوادم', 'en' => 'Server Management'],
                'description' => ['ar' => 'إعداد وإدارة الخوادم وأنظمة Ubuntu و ALMA', 'en' => 'Setup and management of servers and Ubuntu and ALMA systems'],
                'color' => 'cyan',
                'icon' => 'server'
            ],
            [
                'title' => ['ar' => 'استشارات تقنية', 'en' => 'Technical Consulting'],
                'description' => ['ar' => 'استشارات وحلول برمجية لتطوير أعمالك', 'en' => 'Consulting and software solutions to develop your business'],
                'color' => 'indigo',
                'icon' => 'users'
            ],
        ];
        */

        // NEW PROFESSIONAL SERVICES
        $services = [
            [
                'title' => [
                    'ar' => 'تصميم وبرمجة المواقع الاحترافية',
                    'en' => 'Professional Website Design & Development'
                ],
                'description' => [
                    'ar' => 'تطوير مواقع ويب متقدمة للأفراد والشركات باستخدام PHP وإطار عمل Laravel، مع أعلى معايير الأمان والأداء والحماية من الثغرات الأمنية',
                    'en' => 'Advanced web development for individuals and companies using PHP and Laravel framework, with the highest security standards, performance, and protection against vulnerabilities'
                ],
                'color' => 'purple',
                'icon' => 'code'
            ],
            [
                'title' => [
                    'ar' => 'إدارة السيرفرات والدعم الفني',
                    'en' => 'Server Management & Technical Support'
                ],
                'description' => [
                    'ar' => 'إدارة شاملة للخوادم وتثبيت المكتبات والأدوات المطلوبة، مع دعم فني لحظي متواصل لضمان استمرارية عمل أنظمتك بكفاءة عالية',
                    'en' => 'Comprehensive server management and installation of required libraries and tools, with instant continuous technical support to ensure your systems run efficiently'
                ],
                'color' => 'blue',
                'icon' => 'server'
            ],
            [
                'title' => [
                    'ar' => 'بناء أنظمة الأتمتة الذكية',
                    'en' => 'Smart Automation Systems Development'
                ],
                'description' => [
                    'ar' => 'تصميم وتطوير حلول أتمتة مخصصة تخدم احتياجات عملك، سواء كنت فرداً أو شركة، لتسهيل العمليات التلقائية وزيادة الإنتاجية وتوفير الوقت والجهد',
                    'en' => 'Design and develop custom automation solutions that serve your business needs, whether individual or corporate, to facilitate automatic processes, increase productivity, and save time and effort'
                ],
                'color' => 'cyan',
                'icon' => 'zap'
            ],
            [
                'title' => [
                    'ar' => 'الاستشارات التقنية المتخصصة',
                    'en' => 'Technical Consulting'
                ],
                'description' => [
                    'ar' => 'استشارات تقنية متخصصة لتحليل احتياجاتك البرمجية واختيار أفضل الحلول التقنية، مع تقديم توصيات احترافية لتطوير البنية التحتية وتحسين الأداء',
                    'en' => 'Specialized technical consulting to analyze your software needs and choose the best technical solutions, with professional recommendations for infrastructure development and performance optimization'
                ],
                'color' => 'indigo',
                'icon' => 'users'
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
