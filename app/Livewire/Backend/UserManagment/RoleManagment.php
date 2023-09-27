<?php

namespace App\Livewire\Backend\UserManagment;

use Livewire\Component;

class RoleManagment extends Component
{

    public $formName = 'RoleManagement';
    public string $modelTitle = 'Add New Role';
    public string $modelBtnTitle = 'Save';
    public string $operationMethod = 'store';
    public array $permissions = [];

    public function render()
    {
        return view('livewire..backend.user-managment.role-managment')->layout('layouts.app');
    }
}
