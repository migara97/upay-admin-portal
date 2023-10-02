<?php

namespace App\Livewire\Backend\Transaction;

use Livewire\Component;

class Payment extends Component
{
    public ?int $filterId = null;
    
    public function render()
    {
        return view('livewire.backend.transaction.payment')->layout('layouts.app');
    }
}
