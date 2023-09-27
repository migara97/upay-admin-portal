<?php

namespace App\Livewire\Backend\MisReport;

use Livewire\Component;

class AppUserList extends Component
{
    public function render()
    {
        return view('livewire..backend.mis-report.app-user-list')->layout('layouts.app');
    }
}
