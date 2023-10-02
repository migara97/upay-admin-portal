<?php

namespace App\Livewire\Backend\Transaction;

use Livewire\Component;

class Refund extends Component
{
    public function render()
    {
        return view('livewire.backend.transaction.refund')->layout('layouts.app');
    }
}
