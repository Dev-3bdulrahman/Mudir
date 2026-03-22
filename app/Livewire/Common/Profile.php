<?php

namespace App\Livewire\Common;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Profile extends Component
{
  public $name, $email, $password, $password_confirmation;

  public function mount()
  {
    $user = auth()->user();
    $this->name = $user->name;
    $this->email = $user->email;
  }

  public function updateProfile()
  {
    $user = auth()->user();

    $this->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable|min:8|confirmed',
    ]);

    $user->update([
      'name' => $this->name,
      'email' => $this->email,
    ]);

    if ($this->password) {
      $user->update(['password' => Hash::make($this->password)]);
    }

    $this->password = '';
    $this->password_confirmation = '';

    $this->dispatch('notify', ['message' => __('Profile updated!'), 'type' => 'success']);
  }

  public function render()
  {
    $layout = 'layouts.admin';

    if (auth()->user()->hasRole('employee')) {
      $layout = 'layouts.staff';
    } elseif (auth()->user()->hasRole('client')) {
      $layout = 'layouts.portal';
    }

    return view('livewire.common.profile')
      ->layout($layout)
      ->title(__('Account Settings'));
  }
}
