<?php

namespace App\Livewire\Backend\BillerManagement;

use Livewire\Component;

class BillerManagement extends Component
{
    public function render()
    {
        return view('livewire.backend.biller-management.biller-management')->layout('layouts.app');
    }
}
