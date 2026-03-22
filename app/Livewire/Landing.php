<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ServicesManagementService;
use App\Services\ProductsManagementService;
use App\Services\PortfolioManagementService;
use App\Services\SettingsManagementService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Landing extends Component
{
    public $services;
    public $products;
    public $portfolio;
    public array $settings = [];

    #[Layout('layouts.guest')] // I'll need to create or verify this layout
    public function mount(
        ServicesManagementService $ss,
        ProductsManagementService $ps,
        PortfolioManagementService $pos,
        SettingsManagementService $sts
    ) {
        $this->services = $ss->getAllServices();
        $this->products = $ps->getAllProducts();
        $this->portfolio = $pos->getAllPortfolioItems();
        $this->settings = $sts->getLocalizedSettings();
    }

    public function render()
    {
        return view('livewire.landing');
    }
}
