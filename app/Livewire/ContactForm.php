<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use Illuminate\Support\Facades\Http;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';
    public $success = false;
    public $contactEmail;
    public $contactPhone;
    public $whatsapp;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string|max:5000',
    ];

    public function mount()
    {
        $this->contactEmail = \App\Models\SiteSetting::getValue('contact_email');
        $this->contactPhone = \App\Models\SiteSetting::getValue('contact_phone');
        $this->whatsapp = \App\Models\SiteSetting::getValue('whatsapp');
    }

    public function submit()
    {
        $this->validate();

        $ip = request()->ip();
        $locationData = $this->getLocationFromIp($ip);

        Lead::create([
            'name' => strip_tags($this->name),
            'email' => filter_var($this->email, FILTER_SANITIZE_EMAIL),
            'phone' => strip_tags($this->phone),
            'subject' => strip_tags($this->subject),
            'message' => strip_tags($this->message),
            'ip_address' => $ip,
            'country' => $locationData['country'] ?? null,
            'city' => $locationData['city'] ?? null,
            'status' => 'new',
        ]);

        $this->success = true;
        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
    }

    private function getLocationFromIp($ip)
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return ['country' => 'Local', 'city' => 'Local'];
        }

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'country' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            // Silent fail
        }

        return ['country' => null, 'city' => null];
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
