<?php

namespace App\Livewire\Backend\BillerManagement;

use App\Enums\AuditTrailAction;
use App\Models\Backend\Biller;
use App\Repository\BillerRepositoryInterface;
use App\Repository\Eloquent\BillerCategoryRepository;
use App\Repository\Eloquent\BillerRepository;
use App\Repository\Eloquent\JustpayBankRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Psr\Log\LogLevel;
use WireUi\Traits\Actions;

class BillerManagement extends Component
{
    use Actions;
    use WithFileUploads;

    private static BillerRepositoryInterface $billerProviderService;

    public bool $providerCreateModal =  false;
    public bool $providerImageUpdateModal = false;

    public string $imageUpdateOperation = "updateProviderImageSave";

    public string $operationMethod = 'store';
    public string $modelTitle = 'Add New Provider';
    public string $modelBtnTitle = 'Save';

    public $banks = [];
    public $categories = [];
    public $labels = [];
    public $label = "";
    public $placeholder = "";

    public string $providerCode = '';
    public string $providerName = '';
    public $category = '';
    public string $convenienceFee;
    public bool $isMobile;
    public bool $isNumber;
    public string $maxLength;
    public string $minLength;
    public $icon;
    public $newIcon;
    public bool $status;
    public $accountNo = '';
    public string $bank = '';
    public string $maxAmount = '9999.00';
    public string $minAmount = '30.00';
    public $uploadFileName = null;
    public $imageUpdateUploadFileName = null;

    public Biller $editBiller;

    protected $listeners =[
        'CreateProvider' => 'openModal',
        'EditProvider' => 'editProvider',
        'ToggleProvider' => 'toggleProvider',
        'UpdateProviderImage' => 'updateProviderImage',
    ];

    protected $rules = [
        'providerCode' => 'required',
        'providerName' => 'required',
        'category' => 'required',
        'convenienceFee' => 'required',
        'isMobile' => 'required',
        'isNumber' => 'required',
        'maxLength' => 'required|numeric',
        'minLength' => 'required|numeric|gt:0',
        'icon' => 'required|image|max:1024|mimes:png,jpeg',
        'status' => 'required',
        'accountNo' => 'required|numeric|digits_between:3,30',
        'maxAmount' => 'required|numeric',
        'minAmount' => 'required|numeric',
        'placeholder' => 'required',
        'label' => 'required'
    ];

    protected $messages = [
        'accountNo.required' => 'The account number filed is required.',
        'accountNo.numeric' => 'The account number must be a number.',
        'accountNo.digits_between' => 'The account number must be between 3 and 30 digits.',
    ];

    public function boot(BillerRepositoryInterface $billerProviderRepository)
    {
        self::$billerProviderService = $billerProviderRepository;
    }

    public function mount(JustpayBankRepository $bankRepository)
    {
        $this->labels = $this->getLabels();
        $this->banks = $bankRepository->getActiveBanks();
    }

    public function render()
    {
        return view('livewire.backend.biller-management.biller-management')->layout('layouts.app');
    }

    public function openModal(BillerCategoryRepository $categoryRepository, JustpayBankRepository $bankRepository)
    {
        $this->modelTitle = 'Add New Provider';
        $this->modelBtnTitle = 'Save';
        $this->operationMethod = 'store';

        $this->categories = $categoryRepository->getActiveCategories();
        $this->banks = $bankRepository->getActiveBanks();
        $this->category = '';
        $this->icon = null;
        $this->providerCode = '';
        $this->providerName = '';
        $this->accountNo = '';
        $this->bank = '';
        $this->maxAmount = '9999.00';
        $this->minAmount = '30.00';
        $this->convenienceFee = 0;
        $this->maxLength = 10;
        $this->minLength = 0;
        $this->isMobile = false;
        $this->isNumber = false;
        $this->status = true;
        $this->labels = $this->getLabels();
        $this->placeholder = '';

        $this->providerCreateModal = true;
    }

    public function closeModal()
    {
        $this->providerCreateModal = false;
    }

    private function getLabels()
    {
        return [
            ['name' => 'Mobile Number'],
            ['name' => 'Bill Number'],
            ['name' => 'Policy Number'],
            ['name' => 'Account Number']
        ];
    }

    public function store(BillerRepositoryInterface $providerService)
    {
        $actionName = "Store biller provider";
        $this->uploadFileName = null;

        if ($this->category && ($this->category == env('CATEGORY_GOV_ID'))) {
            $this->validate([
                'providerCode' => 'required',
                'providerName' => 'required',
                'category' => 'required',
                'icon' => 'required|image|max:1024|mimes:png,jpeg',
                'status' => 'required',
            ]);
        } else {
            $this->validate();
        }
        try {
            if ($this->checkBillerExists()) {
                log_activity($actionName, "A Provider already exists with this details: Provider Code -> [ $this->providerCode ], Name -> [ $this->providerName.]");
                $this->addError('generalError', 'A biller provider already exists with this details.');
                return;
            }

            $uploadFileMessage = null;

            $this->uploadFileName = upload_image($this->icon, function ($message) use (&$uploadFileMessage) {
                $uploadFileMessage = $message;
            });
            
            if($this->uploadFileName == null) {
                log_activity($actionName, $uploadFileMessage);
                $this->addError('imageError', $uploadFileMessage);
                return;
            }

            $this->closeModal();

            $payload = json_encode($this->getProviderPayload());
            log_activity($actionName, 'Data : ' . $payload);

            $providerService->storeProvider(json_decode($payload, true) ['data']);
            log_activity($actionName, "Provider [ $this->providerName ] [ save ] successful.");
            // audit_log(AuditTrailAction::ADD_BILLER->name, "Provider $this->providerName, saved successfully.", null, json_decode($payload, true)['data']);

            $this->notification()->notify([
                'title' => 'Provider Creation Successful!',
                'description' => 'New provider created successfully.',
                'icon' => 'success'
            ]);

            $this->dispatch('reload-biller-table');

        } catch (\Exception $exception) {
            log_activity($actionName, "Provider create failed: Exception -> " . $exception->getMessage() . " - " . $exception->getLine(), null, LogLevel::ERROR);
            $this->notification()->error(
                'Error !!!',
                'New Provider creation failed, please try again!'
            );
        }
    }

    private function checkBillerExists(): bool
    {
        return Biller::query()
                ->where('biller_code', $this->providerCode)
                ->orWhere('biller_name', $this->providerName)
                ->count() > 0;
    }

    private function getProviderPayload(): array
    {
        return [
            'data' => [
                'biller_code' => $this->providerCode,
                'biller_name' => $this->providerName,
                'biller_order' => 1,
                'category_id' => $this->category,
                'convenience_fee' => isset($this->convenienceFee) ? $this->convenienceFee : null,
                'is_mobile' => $this->isMobile == 1,
                'is_num' => $this->isNumber == 1,
                'max_length' => $this->maxLength,
                'min_length' => $this->minLength,
                'provider_image' => $this->uploadFileName,
                'state' => $this->status,
                'account_number' => $this->accountNo,
                'bank_id' => env('UPAY_BANK_ID'), // $this->bank
                'max_amount' => $this->maxAmount,
                'min_amount' => $this->minAmount,
                'place_holder' => $this->placeholder,
                'label' => $this->label
            ],
        ];
    }

    public function editProvider($id, BillerRepository $billerRepository, BillerCategoryRepository $categoryRepository)
    {
        $this->modelTitle = 'Edit Provider';
        $this->modelBtnTitle = 'Update';
        $this->operationMethod = 'update';

        $editBiller = $billerRepository->findBiller($id);

        // Set here to update it later when confirmed by user
        $this->editBiller = $editBiller;
        $this->categories = $categoryRepository->getActiveCategories();
        $this->providerCode = $editBiller->biller_code;
        $this->providerName = $editBiller->biller_name;
        $this->category = $editBiller->category_id ?? "";
        $this->accountNo = $editBiller->account_number;
        $this->bank = $editBiller->bank_id;
        $this->maxAmount = $editBiller->max_amount;
        $this->minAmount = $editBiller->min_amount;
        $this->convenienceFee = $editBiller->convenience_fee;
        $this->maxLength = $editBiller->max_length;
        $this->minLength = $editBiller->min_length;
        $this->isMobile = $editBiller->is_mobile == 1;
        $this->isNumber = $editBiller->is_num == 1;
        $this->status = $editBiller->state == 1;
        $this->placeholder = $editBiller->place_holder;
        $this->label = $editBiller->label;

        $this->providerCreateModal = true;
    }

    public function toggleProvider($data)
    {
        Log::info($data['id']);
        Log::info($data['field']);
        Log::info($data['value']);
        /// Used to handle toggleable
    }

    public function updateProviderImage($data)
    {
        $this->imageUpdateOperation .= ("(" . $data['provider'] . ")");
        $this->newIcon = null;
        $this->providerImageUpdateModal = true;
    }

    public function closeImageUpdateModal()
    {
        $this->providerImageUpdateModal = false;
    }

    public function update()
    {
        $actionName = "Update biller provider";
        if ($this->category && ($this->category == env('CATEGORY_GOV_ID'))) {
            $this->validate([
                'providerCode' => 'required',
                'providerName' => 'required',
                'category' => 'required',
                'status' => 'required',
            ]);
        } else {
            $this->validate(Arr::except($this->rules, 'icon'));
        }
        try {
            $this->closeModal();
            
            $payload = $this->getProviderPayload();
            $payload["data"] = Arr::except($payload["data"], "provider_image");
            $payload['id'] = $this->editBiller->id;
            $payload = json_encode($payload);
            
            log_activity($actionName, 'Data : ' . $payload);

            self::$billerProviderService->updateProvider(json_decode($payload, true)['id'], json_decode($payload, true)['data']);

            $printData = filter_arrays(json_decode(json_encode($this->editBiller), true), json_decode($payload, true)['data']);
            log_activity($actionName, "Provider [ $this->providerName ] [update] successful. ");
            audit_log(AuditTrailAction::EDIT_BILLER->name, "Provider $this->providerName, updated successfully.", json_encode($printData[0]), json_encode($printData[1]));

            $this->notification()->notify([
                'title' => 'Update Successful!',
                'description' => 'Provider updated successfully.',
                'icon' => 'success'
            ]);

            $this->dispatch('reload-biller-table');
        } catch (\Exception $exception) {
            log_activity($actionName, "Provider update failed: Exception -> " . $exception->getMessage(), null, LogLevel::ERROR);
            $this->notification()->error(
                'Error !!!',
                'Provider update failed, please try again!'
            );
        }
    }

    public function categoryChangedCallback(BillerCategoryRepository $categoryRepository)
    {
        $this->categories = $categoryRepository->getActiveCategories();
    }

    public function updateProviderImageSave($id)
    {
        $actionName = "Update biller provider image";
        $this->validate([
            'newIcon' => 'required|image|max:1024|mimes:png,jpeg',
        ]);

        try {

            $uploadFileMessage = null;

            $this->imageUpdateUploadFileName = upload_image($this->newIcon, function ($message) use (&$uploadFileMessage) {
                $uploadFileMessage = $message;
            });

            if ($this->imageUpdateUploadFileName == null) {
                log_activity($actionName, $uploadFileMessage);
                $this->addError('newImageError', $uploadFileMessage);
                return;
            }

            $this->closeImageUpdateModal();

            $payload = json_encode([
                "id" => $id,
                "data" => [
                    'provider_image' => $this->imageUpdateUploadFileName
                ],
            ]);

            log_activity($actionName, 'Data : ' . $payload);

            $imageUpdateBiller = self::$billerProviderService->findBiller($id);

            self::$billerProviderService->updateProvider(json_decode($payload, true)['id'], json_decode($payload, true)['data']);
            
            $printData = filter_arrays(json_decode(json_encode($imageUpdateBiller), true), json_decode($payload, true)["data"]);

            log_activity($actionName, "Provider [ $this->providerName ] [ update image ] successful.");
            audit_log(AuditTrailAction::EDIT_BILLER->name, "Provider $this->providerName, image updated successfully.", json_encode($printData[0]), json_encode($printData[1]));

            $this->notification()->success(
                'Image Update Successful!',
                'Provider image updated successfully.',
            );

            $this->dispatch('reload-biller-table');

        } catch (\Exception $exception) {
            log_activity($actionName, "Provider image update failed: Exception -> " . $exception->getMessage() . " - " . $exception->getLine(), null, LogLevel::ERROR);
            $this->notification()->error(
                'Error !!!',
                'Provider image update failed, please try again!'
            );
        }
    }
}
