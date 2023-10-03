<?php

namespace App\Livewire\Backend\BillerManagement;

use App\Repository\BillerCategoryRepositoryInterface;
use Livewire\Component;
use PHPUnit\Exception;
use Psr\Log\LogLevel;

class BillerCategoryManagement extends Component
{

    public string $formName = 'ProviderCategoryManagement';

    public bool $categoryCreateModal = false;
    public string $operationMethod = 'store';
    public string $modelTitle = 'Add New Category';
    public string $modelBtnTitle = 'Save';

    public bool $dualAuthRequired = true;

    public string $categoryId = "";
    public string $categoryName = "";
    public $categoryStatus = "";

    public $editCategory;

    public bool $pendingSummaryModel = false;
    public $summaryData;

    protected $listeners = [
        'CreateCategory' => 'openModal',
    ];
    public function render()
    {
        return view('livewire.backend.biller-management.biller-category-management')->layout('layouts.app');
    }

    public function openModal()
    {
        $this->modelTitle = 'Add New Category';
        $this->modelBtnTitle = 'Save';
        $this->operationMethod = 'store';

        $this->category = '';
        $this->categories = [];
        $this->categoryCreateModal = true;
        $this->icon = null;
    }

    public function closeModal()
    {
        $this->categoryCreateModal = false;
    }

    public function store(BillerCategoryRepositoryInterface   $categoryRepository)
    {
        $actionName = "Store biller category";
        $this->validate();

        try {

        } catch (Exception $exception) {
//            log_activity($actionName, "Category create failed: Exception -> " . $exception->getMessage(), null, LogLevel::ERROR);
            $this->notification()->error(
                'Error !!!',
                'New category creation failed, please try again!'
            );
        }

    }
}
