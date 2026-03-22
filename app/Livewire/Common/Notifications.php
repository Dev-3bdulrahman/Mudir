<?php

namespace App\Livewire\Common;

use Livewire\Component;

class Notifications extends Component
{
  public function getNotificationsProperty()
  {
    return auth()->user()->unreadNotifications;
  }

  public function markAsRead($id)
  {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    if (isset($notification->data['url'])) {
      return $this->redirect($notification->data['url'], navigate: true);
    }
  }

  public function markAllAsRead()
  {
    auth()->user()->unreadNotifications->markAsRead();
  }

  public function render()
  {
    return view('livewire.common.notifications');
  }
}
