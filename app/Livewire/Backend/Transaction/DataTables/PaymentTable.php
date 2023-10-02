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

final class PaymentTable extends PowerGridComponent
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
        $tranData = Transaction::query()->whereIn('payment_category', ['BILL_PAY', 'GOVERNMENT_PAYMENT'])
            ->select([
                'transaction.id',
                'transaction.transaction_reference',
                'transaction.payer_id',
                'transaction.payer_email',
                'transaction.payment_method',
                'transaction.paying_amount',
                'transaction.currency',
                'transaction.biller_name',
                'transaction.bill_payment_account_number',
                'transaction.payment_method_id',
                'transaction.payer_bank_name',
                'transaction.status',
                'transaction.bank_stan',
                'transaction.bank_rrn',
                'transaction.bank_reference_id',
                'transaction.payer_account_number',
                'transaction.created_at',
                'transaction.bank_response',
                'transaction.biller_response',
                'transaction.original_amount',
                'transaction.payer_login_id',
                'transaction.lpopp_reference',
                'transaction.lpopp_mcc',
                'transaction.linked_tran_id',
                'transaction.fee',
                'transaction.status_description',
                'transaction.payer_reference',
                'transaction.beneficiary_reference',
                'app_user.nic',
                'app_user.phone_number',
            ]) ->leftJoin('app_user', 'transaction.payer_id', '=', 'app_user.username')->orderByDesc('id');

        // if ($this->filterFullTranId != null) {
        //     $tranData->where(function ($q) {
        //         $q->where('transaction.id', $this->filterFullTranId)
        //             ->orWhere('transaction.linked_tran_id', $this->filterFullTranId);
        //     });
        // }

        return $tranData;
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
                ->searchable()
                ->field('phone_number'),

            Column::add()
                ->title('Payment Method')
                ->field('payment_method'),

            Column::add()
                ->title('Payer Account/Card Number')
                ->field('payer_account_number'),

            Column::add()
                ->title('Paying Amount')
                ->bodyAttribute('', 'text-align: right')
                ->field('paying_amount'),

            Column::add()
                ->title('Amount')
                ->bodyAttribute('', 'text-align: right')
                ->field('original_amount'),

            Column::add()
                ->title('Fee')
                ->bodyAttribute('text-right')
                ->field('fee'),

            Column::add()
                ->title('Currency')
                ->field('currency'),

            Column::add()
                ->title('Biller Name')
                ->field('biller_name'),

            Column::add()
                ->title('Bill Payment Account')
                ->field('bill_payment_account_number'),

            Column::add()
                ->title('Status')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:150px')
                ->bodyAttribute('text-center')
                ->field('status'),

            Column::add()
                ->title('Success/Failed Reason')
                ->field('status_description'),

            Column::add()
                ->title('Status')
                ->hidden()
                ->visibleInExport(true)
                ->field('status_values'),
            Column::add()
                ->title('Payer Bank')
                ->field('payer_bank_name'),

            Column::add()
                ->title('Bank RRN')
                ->field('bank_rrn'),

            Column::add()
                ->title('Bank STAN')
                ->field('bank_stan'),

            Column::add()
                ->title('Bank Reference')
                ->field('bank_reference_id'),

            Column::add()
                ->title('Transaction Reference')
                ->field('id'),

            Column::add()
                ->title('Linked Transaction ID')
                ->field('linked_tran_id'),

            Column::add()
                ->title('Biller Response')
                ->field('biller_response'),

            Column::add()
                ->title('LPOPP Reference')
                ->field('lpopp_reference'),

            Column::add()
                ->title('LPOPP MCC')
                ->field('lpopp_mcc'),

            Column::add()
                ->title('User Reference')
                ->field('payer_reference'),

            Column::add()
                ->title('Beneficiary Reference')
                ->field('beneficiary_reference'),
        ];
    }

    // public function filters(): array
    // {
    //     return [
    //         Filter::inputText('name'),
    //         Filter::datepicker('created_at_formatted', 'created_at'),
    //     ];
    // }

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
