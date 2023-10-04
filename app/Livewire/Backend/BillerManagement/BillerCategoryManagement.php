<?php

namespace App\Livewire\Backend\BillerManagement;

use App\Enums\AuditTrailAction;
use App\Models\Backend\BillerCategory;
use App\Repository\BillerCategoryRepositoryInterface;
use App\Repository\Eloquent\BillerCategoryRepository;
use Livewire\Component;
use PHPUnit\Exception;
use Psr\Log\LogLevel;
use WireUi\Traits\Actions;

class BillerCategoryManagement extends Component
{

    use Actions;

    public string $formName = 'ProviderCategoryManagement';

    public bool $categoryCreateModal = false;
    public string $operationMethod = 'store';
    public string $modelTitle = 'Add New Category';
    public string $modelBtnTitle = 'Save';

    public bool $dualAuthRequired = true;

    public string $categoryId = "";
    public string $categoryName = "";
    public $categoryStatus = true;

    public $editCategory;

    public bool $pendingSummaryModel = false;
    public $summaryData;

    protected $listeners = [
        'CreateCategory' => 'openModal',
        'EditCategory' => 'editCategory',
    ];

    protected $rules = [
        'categoryId' => 'required|numeric|digits_between:1,20',
        'categoryName' => 'required|regex:/^[a-zA-Z0-9 ]+$/',
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

    public function store(BillerCategoryRepositoryInterface $categoryRepository)
    {
        $actionName = "Store biller category";
        $this->validate();

        try {
            if ($this->checkCategoryExists()) {
                log_activity($actionName, "A Category already exists with this details: Id -> $this->categoryId, Name -> $this->categoryName.");
                $this->addError('generalError', 'A Category already exists with this details.');
                return;
            }
            $this->closeModal();

            $payload = json_encode($this->getCategoryPayload());
            log_activity($actionName, 'Data : ' . $payload);

            $categoryRepository->storeCategory(json_decode($payload, true)['data']);
            log_activity($actionName, "Provider category [ $this->categoryName ] [ save ] successful.");
            audit_log(AuditTrailAction::ADD_BILLER_CATEGORY->name, "Provider category $this->categoryName, saved successfully.", null, json_encode(json_decode($payload, true)['data']));

            $this->notification()->success(
                'Category Created!',
                'New category created successfully.',
            );

            $this->dispatch('reload-category-table');

        } catch (Exception $exception) {
//            log_activity($actionName, "Category create failed: Exception -> " . $exception->getMessage(), null, LogLevel::ERROR);
            $this->notification()->error(
                'Error !!!',
                'New category creation failed, please try again!'
            );
        }

    }

    private function checkCategoryExists(): bool
    {
        return BillerCategory::query()
                ->where('id', $this->categoryId)
                ->orWhere('name', $this->categoryName)
                ->count() > 0;
    }

    private function getCategoryPayload(): array
    {
        return [
            'data' => [
                'category_id' => $this->categoryId,
                'category_order' => 1,
                'category_status' => ($this->categoryStatus === true) ? 1 : 0,
                'name' => $this->categoryName,
            ],
        ];
    }

    public function editCategory($id, BillerCategoryRepository $categoryRepository)
    {
        $this->editCategory = $categoryRepository->findCategory($id);

        $this->modelTitle = 'Edit Category';
        $this->modelBtnTitle = 'Update';
        $this->operationMethod = 'update';

        $this->categoryName = $this->editCategory->name;
        $this->categoryId = $this->editCategory->category_id;
        $this->categoryStatus = $this->editCategory->category_status == 1;

        $this->resetErrorBag();
        $this->resetValidation();

        $this->categoryCreateModal = true;
    }

    public function update(BillerCategoryRepositoryInterface   $categoryRepository)
    {
        $actionName = "Update provider category";
        $this->validate();

        try {
            if ($this->checkOtherCategoryExists()) {
                log_activity($actionName, "A Provider category already exists with this details: Category ID -> [ $this->categoryId ], Name -> [ $this->categoryName ].");
                $this->addError('generalError', 'A provider category already exists with this details.');
                return;
            }

            $this->closeModal();

            $payload = $this->getCategoryPayload();
            $payload['id'] = $this->editCategory->id;
            $payload = json_encode($payload);

            log_activity($actionName, 'Data : ' . $payload);
            $categoryRepository->storeCategoryUpdate($this->editCategory->id, json_decode($payload, true)['data']);

//            $printData = filter_arrays(json_decode(json_encode($this->editCategory), true), json_decode($payload, true)['data']);
//
//            log_activity($actionName, "Provider category [ $this->categoryName ] [ update ] successful.");
//            audit_log(AuditTrailAction::EDIT_BILLER_CATEGORY->name, "Provider category $this->categoryName, updated successfully.", json_encode($printData[0]), json_encode($printData[1]));

            $this->notification()->success(
                'Provider Category Updated!',
                'Provider Category updated successfully.',
            );
        }catch (\Exception $exception) {
            log_activity($actionName, "Provider category update failed: Exception -> " . $exception->getMessage() . " - " . $exception->getLine(), null, LogLevel::ERROR);
            $this->notification()->error(
                'Error !!!',
                'Provider category update failed, please try again!'
            );
        }

        $this->dispatch('reload-category-table');
    }

    private function checkOtherCategoryExists(): bool
    {
        $bc = BillerCategory::query()
            ->where('name', $this->categoryName)
            ->whereNot('id', $this->editCategory->id);

        if ($this->categoryId != $this->editCategory->id) {
            $bc->where('category_id', $this->categoryId);
        }

        return $bc->count() > 0;
    }
}
