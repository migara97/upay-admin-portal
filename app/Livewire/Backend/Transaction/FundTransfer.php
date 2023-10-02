<?php

namespace App\Livewire\Backend\Transaction;

use Livewire\Component;

class FundTransfer extends Component
{
    public function render()
    {
        return view('livewire.backend.transaction.fund-transfer')->layout('layouts.app');
    }
}
