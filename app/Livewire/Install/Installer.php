<?php

namespace App\Livewire\Install;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Layout;

class Installer extends Component
{
    public int $step = 1;

    // Step 1: Database Setup
    public string $db_host = '127.0.0.1';
    public string $db_port = '3306';
    public string $db_database = '';
    public string $db_username = '';
    public string $db_password = '';
    public string $db_connection_status = '';
    
    // Step 3: Product & Identity
    public array $products = [];
    public ?int $selected_product_id = null;
    public string $name = '';
    public string $email = '';
    public string $domain = '';
    
    // Step 4: Auth via Parent
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
            $parentUrl = config('services.parent.url', 'http://localhost:8001');
            $response = Http::get($parentUrl . '/api/v1/products');
            if ($response->successful()) {
                $this->products = $response->json();
            }
        } catch (\Exception $e) {
            $this->products = [];
        }
    }

    public function testDatabaseConnection()
    {
        $this->error_message = '';
        $this->db_connection_status = '';

        try {
            $dsn = "mysql:host={$this->db_host};port={$this->db_port};dbname={$this->db_database}";
            $pdo = new \PDO($dsn, $this->db_username, $this->db_password, [
                \PDO::ATTR_TIMEOUT => 5,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
            $this->db_connection_status = 'success';
            return true;
        } catch (\PDOException $e) {
            $this->error_message = __('Connection Failed') . ': ' . $e->getMessage();
            $this->db_connection_status = 'error';
            return false;
        }
    }

    public function nextStep()
    {
        $this->error_message = '';
        
        if ($this->step === 1) {
            if (!$this->testDatabaseConnection()) return;
            $this->updateEnv();
        } elseif ($this->step === 2) {
            $this->validateRequirements();
        } elseif ($this->step === 3) {
            $this->validateIdentity();
        } elseif ($this->step === 4) {
            $this->processInstallation();
            return;
        }

        if (!$this->error_message) {
            $this->step++;
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    protected function updateEnv()
    {
        $path = base_path('.env');
        if (!File::exists($path)) return;

        $content = File::get($path);
        $content = preg_replace('/DB_HOST=.*/', 'DB_HOST=' . $this->db_host, $content);
        $content = preg_replace('/DB_PORT=.*/', 'DB_PORT=' . $this->db_port, $content);
        $content = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=' . $this->db_database, $content);
        $content = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=' . $this->db_username, $content);
        $content = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD="' . $this->db_password . '"', $content);

        File::put($path, $content);
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
            $parentUrl = config('services.parent.url', 'http://localhost:8001');
            
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
                $this->step = 5; // Success
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
