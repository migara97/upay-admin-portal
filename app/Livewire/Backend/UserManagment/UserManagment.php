<?php

namespace App\Livewire\Backend\UserManagment;

use Livewire\Component;

class UserManagment extends Component
{
    public function render()
    {
        return view('livewire.backend.user-managment.user-managment')->layout('layouts.app');
    }
}
