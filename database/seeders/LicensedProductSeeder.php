<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LicensedProduct;

class LicensedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LicensedProduct::updateOrCreate(
            ['slug' => 'full-admin-dashboard'],
            [
                'name' => [
                    'ar' => 'نظام الإدارة الشامل',
                    'en' => 'Full Admin Dashboard',
                ],
                'description' => [
                    'ar' => 'لوحة تحكم كاملة تشمل الإحصائيات، النشاطات، وحالة الخادم.',
                    'en' => 'Complete admin panel including stats, activity, and server health.',
                ],
                'dashboard_code' => $this->getDashboardCode(),
                'modules' => [
                    'App\Livewire\Admin\Dashboard' => file_get_contents(app_path('Livewire/Admin/Dashboard.php')),
                    'App\Livewire\Admin\Services\Index' => file_get_contents(app_path('Livewire/Admin/Services/Index.php')),
                    'App\Livewire\Admin\Clients\Index' => file_get_contents(app_path('Livewire/Admin/Clients/Index.php')),
                    'App\Livewire\Admin\Projects\Index' => file_get_contents(app_path('Livewire/Admin/Projects/Index.php')),
                    'App\Livewire\Admin\Portfolio\Index' => file_get_contents(app_path('Livewire/Admin/Portfolio/Index.php')),
                    'App\Livewire\Admin\Invoices\Index' => file_get_contents(app_path('Livewire/Admin/Invoices/Index.php')),
                    'App\Livewire\Admin\Tickets\Index' => file_get_contents(app_path('Livewire/Admin/Tickets/Index.php')),
                    'App\Livewire\Admin\Contracts\Index' => file_get_contents(app_path('Livewire/Admin/Contracts/Index.php')),
                    'App\Livewire\Admin\Subscribers\Index' => file_get_contents(app_path('Livewire/Admin/Subscribers/Index.php')),
                ],
            ]
        );
    }

    private function getDashboardCode()
    {
        // Mock data logic to be injected into the Blade view in the child project
        $mockData = <<<'PHP'
@php
    if (!isset($stats)) {
        $stats = [
            'services' => ['count' => 24, 'trend' => 12],
            'products' => ['count' => 8, 'trend' => 5],
            'portfolio' => ['count' => 45, 'trend' => 8],
            'clients' => ['count' => 128, 'trend' => 15],
            'projects' => ['count' => 12, 'trend' => -3],
            'contracts' => ['count' => 34, 'trend' => 10],
            'invoices' => ['count' => 156, 'trend' => 22],
            'tickets' => ['count' => 5, 'trend' => -50],
        ];
    }
    
    if (!isset($recentActivity)) {
        $recentActivity = [
            ['type' => 'Project', 'title' => 'تم إنشاء مشروع جديد: متجر إلكتروني', 'date' => now()->subHours(2), 'time_ago' => 'منذ ساعتين'],
            ['type' => 'Invoice', 'title' => 'فاتورة جديدة بقيمة 500$', 'date' => now()->subHours(5), 'time_ago' => 'منذ 5 ساعات'],
            ['type' => 'Ticket', 'title' => 'تذكرة دعم فني جديدة', 'date' => now()->subDay(), 'time_ago' => 'منذ يوم'],
        ];
    }

    if (!isset($visitorStats)) {
        $visitorStats = [
            'total_today' => 1250,
            'unique_today' => 450,
            'top_pages' => collect([
                (object)['url' => '/dashboard', 'count' => 450],
                (object)['url' => '/products', 'count' => 320],
                (object)['url' => '/contact', 'count' => 120],
            ]),
        ];
    }
    
    $auditResults = $auditResults ?? null;
    $showAllActivity = $showAllActivity ?? false;
@endphp
PHP;

        // Get the view content from the project
        $viewPath = resource_path('views/livewire/admin/dashboard.blade.php');
        $viewContent = file_exists($viewPath) ? file_get_contents($viewPath) : '<div>Dashboard view not found.</div>';

        return $mockData . "\n" . $viewContent;
    }
}
