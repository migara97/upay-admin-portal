<?php

namespace App\Livewire\Backend\Transaction;

use Livewire\Component;

class CardSettlement extends Component
{
    public function render()
    {
        return view('livewire.backend.transaction.card-settlement')->layout('layouts.app');
    }
}
