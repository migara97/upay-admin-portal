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

final class RefundTable extends PowerGridComponent
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
        return Transaction::query()->where('payment_category', 'REFUND')
            ->select([
                'transaction.id',
                'transaction.transaction_reference',
                'transaction.payer_id',
                'transaction.payer_email',
                'transaction.payment_method',
                'transaction.fund_transfer_type',
                'transaction.linked_tran_id',
                'transaction.payee_account_number',
                'transaction.payer_account_name',
                'transaction.payee_account_name',
                'transaction.payee_bank_name',
                'transaction.payer_account_number',
                'transaction.payer_bank_name',
                'transaction.payment_method',
                'transaction.payment_type_description',
                'transaction.paying_amount',
                'transaction.currency',
                'transaction.status',
                'transaction.bank_reference_id',
                'transaction.created_at',
                'transaction.bank_response',
                'transaction.original_amount',
                'transaction.payer_login_id',
                'transaction.payer_reference',
                'app_user.nic',
                'app_user.phone_number'
            ])
            ->leftJoin('app_user', 'transaction.payer_login_id', '=', 'app_user.name')
            ->orderBy($this->sortField ?? 'id', $this->sortField == 'id' ? 'DESC' : $this->sortDirection);
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
                ->title('Transaction ID')
                ->field('id'),

            Column::add()
                ->title('Transaction Reference')
                ->field('transaction_reference'),

            Column::add()
                ->title('User ID')
                ->field('payer_login_id'),

            Column::add()
                ->title('Payer Account Name')
                ->field('payer_account_name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Payer NIC')
                ->searchable()
                ->field('nic'),


            Column::add()
                ->title('Payer Mobile')
                ->field('phone_number'),

            Column::add()
                ->title('Payment Method')
                ->field('payment_method'),

            Column::add()
                ->title('Paying Amount')
                ->bodyAttribute('', 'text-align: right')
                ->field('paying_amount'),

            Column::add()
                ->title('Currency')
                ->field('currency'),

            Column::add()
                ->title('Fund Transfer Type')
                ->field('fund_transfer_type_formated'),

            Column::add()
                ->title('Linked Transaction Id')
                ->field('linked_tran_id'),

            Column::add()
                ->title('Payee Account Name')
                ->field('payee_account_name'),

            Column::add()
                ->title('Status')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:150px')
                ->bodyAttribute('text-center')
                ->field('status'),

            Column::add()
                ->title('Payee Account Number')
                ->field('payee_account_number'),

            Column::add()
                ->title('Payee Bank Name')
                ->field('payee_bank_name'),

            Column::add()
                ->title('Payer Account Number')
                ->field('payer_account_number'),

            Column::add()
                ->title('Payer Bank Name')
                ->field('payer_bank_name'),


            Column::add()
                ->title('Payment Type Description')
                ->field('payment_type_description'),

            Column::add()
                ->title('Status')
                ->hidden()
                ->visibleInExport(true)
                ->field('status_values'),

            Column::add()
                ->title('Transaction Reference')
                ->field('bank_reference_id'),

            Column::add()
                ->title('Created at')
                ->field('created_at_formatted'),

            Column::add()
                ->title('Bank Response')
                ->field('bank_response'),

            Column::add()
                ->title('Payer Reference')
                ->field('payer_reference'),
                
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
