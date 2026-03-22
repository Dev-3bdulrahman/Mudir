<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LicensedProduct;
use App\Models\Subscriber;

class LicensedProductSeeder extends Seeder
{
    private function moduleFiles(): array
    {
        return [
            'App\\Livewire\\Admin\\Dashboard'                => app_path('Livewire/Admin/Dashboard.php'),
            'App\\Livewire\\Admin\\Services\\Index'          => app_path('Livewire/Admin/Services/Index.php'),
            'App\\Livewire\\Admin\\Products\\Index'          => app_path('Livewire/Admin/Products/Index.php'),
            'App\\Livewire\\Admin\\Portfolio\\Index'         => app_path('Livewire/Admin/Portfolio/Index.php'),
            'App\\Livewire\\Admin\\Leads\\Index'             => app_path('Livewire/Admin/Leads/Index.php'),
            'App\\Livewire\\Admin\\Settings\\Index'          => app_path('Livewire/Admin/Settings/Index.php'),
            'App\\Livewire\\Admin\\Clients\\Index'           => app_path('Livewire/Admin/Clients/Index.php'),
            'App\\Livewire\\Admin\\Projects\\Index'          => app_path('Livewire/Admin/Projects/Index.php'),
            'App\\Livewire\\Admin\\Projects\\Show'           => app_path('Livewire/Admin/Projects/Show.php'),
            'App\\Livewire\\Admin\\ProjectTypes\\Index'      => app_path('Livewire/Admin/ProjectTypes/Index.php'),
            'App\\Livewire\\Admin\\Invoices\\Index'          => app_path('Livewire/Admin/Invoices/Index.php'),
            'App\\Livewire\\Admin\\Quotations\\Index'        => app_path('Livewire/Admin/Quotations/Index.php'),
            'App\\Livewire\\Admin\\Contracts\\Index'         => app_path('Livewire/Admin/Contracts/Index.php'),
            'App\\Livewire\\Admin\\ContractTemplates\\Index' => app_path('Livewire/Admin/ContractTemplates/Index.php'),
            'App\\Livewire\\Admin\\Tickets\\Index'           => app_path('Livewire/Admin/Tickets/Index.php'),
            'App\\Livewire\\Admin\\Tickets\\Show'            => app_path('Livewire/Admin/Tickets/Show.php'),
            'App\\Livewire\\Admin\\Todos\\Index'             => app_path('Livewire/Admin/Todos/Index.php'),
            'App\\Livewire\\Admin\\Employees\\Index'         => app_path('Livewire/Admin/Employees/Index.php'),
            'App\\Livewire\\Admin\\Visitors\\Index'          => app_path('Livewire/Admin/Visitors/Index.php'),
            'App\\Livewire\\Auth\\Login'                     => app_path('Livewire/Auth/Login.php'),
            'App\\Livewire\\Common\\Notifications'           => app_path('Livewire/Common/Notifications.php'),
            'App\\Livewire\\Common\\Profile'                 => app_path('Livewire/Common/Profile.php'),
            'App\\Livewire\\ContactForm'                     => app_path('Livewire/ContactForm.php'),
            'App\\Livewire\\Landing'                         => app_path('Livewire/Landing.php'),
            'App\\Livewire\\Portal\\Dashboard'               => app_path('Livewire/Portal/Dashboard.php'),
            'App\\Livewire\\Staff\\Dashboard'                => app_path('Livewire/Staff/Dashboard.php'),
            'App\\Livewire\\Staff\\Projects\\Index'          => app_path('Livewire/Staff/Projects/Index.php'),
            'App\\Livewire\\Staff\\Projects\\Show'           => app_path('Livewire/Staff/Projects/Show.php'),
            'App\\Livewire\\Staff\\Tickets\\Index'           => app_path('Livewire/Staff/Tickets/Index.php'),
            'App\\Livewire\\Staff\\Tickets\\Show'            => app_path('Livewire/Staff/Tickets/Show.php'),
            'App\\Livewire\\Staff\\Todos\\Index'             => app_path('Livewire/Staff/Todos/Index.php'),
            'App\\Services\\BaseService'                     => app_path('Services/BaseService.php'),
            'App\\Services\\SettingsManagementService'       => app_path('Services/SettingsManagementService.php'),
            'App\\Services\\ServicesManagementService'       => app_path('Services/ServicesManagementService.php'),
            'App\\Services\\ProductsManagementService'       => app_path('Services/ProductsManagementService.php'),
            'App\\Services\\PortfolioManagementService'      => app_path('Services/PortfolioManagementService.php'),
        ];
    }

    private function readSources(): array
    {
        $sources = [];
        foreach ($this->moduleFiles() as $class => $path) {
            if (file_exists($path)) {
                $sources[$class] = file_get_contents($path);
            }
        }
        return $sources;
    }

    public function run(): void
    {
        $sources = $this->readSources();

        // ── 1. Store/update the base LicensedProduct (plain-text, used as template) ──
        $product = LicensedProduct::updateOrCreate(
            ['slug' => 'full-admin-dashboard'],
            [
                'name'           => ['ar' => 'نظام الإدارة الشامل', 'en' => 'Full Admin Dashboard'],
                'description'    => ['ar' => 'لوحة تحكم كاملة تشمل جميع الوحدات.', 'en' => 'Complete admin panel including all modules.'],
                'modules'        => $sources,
                'dashboard_code' => null,
            ]
        );

        $this->command->info("✅ LicensedProduct base updated: " . count($sources) . " modules.");

        // ── 2. Encrypt modules per-subscriber using their unique key ──────────────
        $subscribers = Subscriber::where('licensed_product_id', $product->id)
                                 ->whereNotNull('child_app_key')
                                 ->get();

        if ($subscribers->isEmpty()) {
            $this->command->warn('No subscribers with child_app_key found. Skipping per-subscriber encryption.');
            $this->command->warn('Set child_app_key on each subscriber and re-run this seeder.');
            return;
        }

        foreach ($subscribers as $subscriber) {
            $encrypted = [];
            foreach ($sources as $class => $code) {
                $encrypted[$class] = $subscriber->encryptModule($code);
            }

            $subscriber->update(['encrypted_modules' => json_encode($encrypted)]);

            $this->command->info("🔐 Encrypted for {$subscriber->domain}: " . count($encrypted) . " modules.");
        }
    }
}
