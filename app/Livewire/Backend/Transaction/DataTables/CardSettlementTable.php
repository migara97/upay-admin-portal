<?php

namespace App\Livewire\Backend\Transaction\DataTables;

use App\Models\Backend\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CardSettlementTable extends PowerGridComponent
{
    use WithExport;

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
        return Transaction::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('created_at_formatted', fn (Transaction $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
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
                ->title('Payment Processor')
                ->field('payment_processor'),
            Column::add()
                ->title('Card Settlement Type')
                ->field('fund_transfer_type_formated'),
            Column::add()
                ->title('Payee Name')
                ->field('payee_account_name'),
            Column::add()
                ->title('Payee Bank Name')
                ->field('payee_bank_name'),
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
                ->title('Status')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:150px')
                ->bodyAttribute('text-center')
                ->field('status_labels'),
            Column::add()
                ->title('Status')
                ->visibleInExport(true)
                ->hidden()
                ->field('status_values'),
            Column::add()
                ->title('Payment Type Description')
                ->field('payment_type_description'),
            Column::add()
                ->title('Payee Card Mask')
                ->field('final_payee_account_mask'),
            Column::add()
                ->title('Linked Transaction ID')
                ->field('linked_tran_id'),
            Column::add()
                ->title('Bank Reference')
                ->field('bank_reference_id'),
            Column::add()
                ->title('Transaction Reference')
                ->field('id'),
            Column::add()
                ->title('Bank Response')
                ->field('bank_response'),
            Column::add()
                ->title('Payer Reference')
                ->field('payer_reference'),
            Column::add()
                ->title('Beneficiary Reference')
                ->field('beneficiary_reference'),

        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

//    public function actions(\App\Models\Backend\Transaction $row): array
//    {
//        return [
//            Button::add('edit')
//                ->slot('Edit: '.$row->id)
//                ->id()
//                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
//                ->dispatch('edit', ['rowId' => $row->id])
//        ];
//    }

    /*
    public function actionRules($row): array
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
