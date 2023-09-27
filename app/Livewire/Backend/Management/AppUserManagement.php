<?php

namespace App\Livewire\Backend\Management;

use Livewire\Component;

class AppUserManagement extends Component
{
    public function render()
    {
        return view('livewire.backend.management.app-user-management')->layout('layouts.app');
    }
}
