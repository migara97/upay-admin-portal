<?php

namespace App\Livewire\Backend\BillerManagement;

use Livewire\Component;

class BillerManagement extends Component
{
    public bool $providerCreateModal =  false;

    public string $operationMethod = 'store';
    public string $modelTitle = 'Add New Provider';
    public string $modelBtnTitle = 'Save';

    public $categories = [];

    public $category = '';
    public $icon;

    protected $listeners =[
        'CreateProvider' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.backend.biller-management.biller-management')->layout('layouts.app');
    }

    public function openModal()
    {
        $this->modelTitle = 'Add New Provider';
        $this->modelBtnTitle = 'Save';
        $this->operationMethod = 'store';

        $this->category = '';
        $this->categories = [];
        $this->providerCreateModal = true;
        $this->icon = null;
    }

    public function closeModal()
    {
        $this->providerCreateModal = false;
    }
}
