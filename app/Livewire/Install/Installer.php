<?php

namespace App\Livewire\Install;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Layout;

class Installer extends Component
{
    public int $step = 1;
    
    // Step 2: Product & Identity
    public array $products = [];
    public ?int $selected_product_id = null;
    public string $name = '';
    public string $email = '';
    public string $domain = '';
    
    // Step 3: Auth via Parent
    public string $auth_mode = 'register'; // register, login
    public string $password = '';
    
    // Status
    public string $error_message = '';
    public bool $is_installing = false;

    public function mount()
    {
        if (file_exists(storage_path('app/license_config.json'))) {
            return redirect()->route('admin.dashboard');
        }
        $this->domain = request()->getHost();
        $this->fetchProducts();
    }

    public function fetchProducts()
    {
        try {
            $parentUrl = config('services.parent.url', 'http://localhost:8000');
            $response = Http::get($parentUrl . '/api/v1/products');
            if ($response->successful()) {
                $this->products = $response->json();
            }
        } catch (\Exception $e) {
            $this->products = [];
        }
    }

    public function nextStep()
    {
        $this->error_message = '';
        
        if ($this->step === 1) {
            $this->validateRequirements();
        } elseif ($this->step === 2) {
            $this->validateIdentity();
        } elseif ($this->step === 3) {
            $this->processInstallation();
            return;
        }

        if (!$this->error_message) {
            $this->step++;
        }
    }

    protected function validateRequirements()
    {
        if (phpversion() < '8.2') {
            $this->error_message = 'PHP version must be 8.2 or higher.';
        }
        if (!is_writable(storage_path('app'))) {
            $this->error_message = 'Storage directory is not writable.';
        }
    }

    protected function validateIdentity()
    {
        $this->validate([
            'selected_product_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'domain' => 'required',
        ]);
    }

    protected function processInstallation()
    {
        $this->is_installing = true;
        
        try {
            $parentUrl = config('services.parent.url', 'http://localhost:8000');
            
            $response = Http::post($parentUrl . '/api/v1/install/activate', [
                'name' => $this->name,
                'email' => $this->email,
                'domain' => $this->domain,
                'product_id' => $this->selected_product_id,
                'auth_mode' => $this->auth_mode,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->saveConfig($data);
                $this->step = 4; // Success
            } else {
                $this->error_message = $response->json('message', 'Installation failed.');
            }
        } catch (\Exception $e) {
            $this->error_message = 'Connection to licensing server failed.';
        } finally {
            $this->is_installing = false;
        }
    }

    protected function saveConfig($data)
    {
        $config = [
            'domain' => $this->domain,
            'license_key' => $data['license_key'],
            'product_slug' => $data['product_slug'],
            'installed_at' => now()->toDateTimeString(),
        ];

        File::put(storage_path('app/license_config.json'), json_encode($config, JSON_PRETTY_PRINT));
    }

    #[Layout('layouts.installer')]
    public function render()
    {
        return view('livewire.install.installer');
    }
}
