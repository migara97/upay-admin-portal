<?php

namespace App\Livewire\Backend\Transaction\DataTables;

use App\Models\Backend\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class LankaQrTable extends PowerGridComponent
{
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $transactions = Transaction::query()
            ->whereIn('payment_category', ['LANKAQR', 'VISA_MASTER_QR'])
            ->select([
                'transaction.id',
                'transaction.transaction_reference',
                'transaction.payer_id',
                'transaction.payer_email',
                'transaction.paying_amount',
                'transaction.currency',
                'transaction.payment_method_id',
                'transaction.status',
                'transaction.linked_tran_id',
                'transaction.payment_processor',
                'transaction.fund_transfer_type',
                'transaction.payer_account_number',
                'transaction.final_payee_account_mask',
                'transaction.bank_reference_id',
                'transaction.payment_type_description',
                'transaction.created_at',
                'transaction.original_amount',
                'app_user.nic',
                'app_user.phone_number',
                'bank_response',
                'transaction.payer_login_id',
                'transaction.payer_bank_name',
                'transaction.payer_bank_code',
                'transaction.payer_account_name',
                'transaction.payee_name',
                'transaction.bank_rrn',
                'transaction.qr_mid',
                'transaction.payee_id',
                'transaction.payee_bank_code',
                'transaction.payee_bank_name',
                'transaction.qr_mcc',
                'transaction.payer_reference',
                'transaction.payee_account_number'
            ]);

            $transactions->orderBy($this->sortField ?? 'id', $this->sortField == 'id' ? 'DESC' : $this->sortDirection)
            ->leftJoin('app_user', 'transaction.payer_id', '=', 'app_user.username');

        return $transactions;
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('name_lower', fn (Transaction $model) => strtolower(e($model->name)))
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Transaction $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Created at')
                ->field('created_at_formatted'),
                
            Column::add()
                ->title('Transaction ID')
                ->field('transaction_reference'),

            Column::add()
                ->title('User ID')
                ->field('payer_login_id'),

            Column::add()
                ->title('Payer Email')
                ->field('payer_email'),

            Column::add()
                ->title('Payer NIC')
                ->field('nic'),

            Column::add()
                ->title('Payer Mobile')
                ->field('phone_number'),

            Column::add()
                ->title('Payer Account Number')
                ->field('payer_account_number'),

            Column::add()
                ->title('Paying Amount')
                ->bodyAttribute('', 'text-align: right')
                ->field('paying_amount'),

            Column::add()
                ->title('Currency')
                ->field('currency'),
                
            Column::add()
                ->title('Status')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:150px')
                ->bodyAttribute('text-center')
                // ->makeInputEnumSelect(\App\Enums\PaymentStatusType::cases(), 'transaction.status')
                ->field('status_labels'),

            Column::add()
                ->title('Status')
                ->visibleInExport(true)
                ->hidden()
                ->field('status_values'),

//    payer bank name
            Column::add()
                ->title('Source Account Bank')
                ->field('payer_bank_name'),
//    payer bank code
            Column::add()
                ->title('Source Account Bank Code')
                ->field('payer_bank_code'),
//    payer_account_name
            Column::add()
                ->title('Customer Name')
                ->field('payer_account_name'),
//    payee_name
            Column::add()
                ->title('Merchant Name')
                ->field('payee_name'),

//    payer payee both seylan
//    bank rrn as credit rrn

            Column::add()
                ->title('Credit RRN')
                ->field('bank_rrn'),
            Column::add()
                ->title('MID')
                ->field('qr_mid'),

            Column::add()
                ->title('TID')
                ->field('terminal_id'),

            Column::add()
                ->title('Merchant Bank Code')
                ->field('payee_bank_code'),

            Column::add()
                ->title('Merchant Bank Name')
                ->field('payee_bank_name'),

            Column::add()
                ->title('MCC')
                ->field('qr_mcc'),

            Column::add()
                ->title('Narration')
                ->field('payer_reference'),

            Column::add()
                ->title('Bank Reference')
                ->field('bank_reference_id'),
            Column::add()
                ->title('Transaction Reference')
                ->field('id'),

            Column::add()
                ->title('Customer'),
            Column::add()
                ->title('Merchant')
                ->field('merchant_onus_offus'),

            Column::add()
                ->title('Type')
                ->field('qr_type'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    // public function actions(\App\Models\Backend\Transaction $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

    /*
    public function actionRules(\App\Models\Backend\Transaction $row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
