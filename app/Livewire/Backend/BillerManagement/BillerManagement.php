<?php

namespace App\Livewire\Backend\BillerManagement;

use App\Models\Backend\Biller;
use App\Repository\BillerRepositoryInterface;
use App\Repository\Eloquent\BillerCategoryRepository;
use App\Repository\Eloquent\JustpayBankRepository;
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

    protected $listeners =[
        'CreateProvider' => 'openModal'
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
}
