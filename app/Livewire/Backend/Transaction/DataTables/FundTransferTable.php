<?php

namespace App\Livewire\Backend\Transaction\DataTables;

use App\Models\Backend\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class FundTransferTable extends PowerGridComponent
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

    public function datasource(): ?Builder
    {
        $tranData = Transaction::query()->whereIn('payment_category', ['FUND_TRANSFER', 'FUND_TRANSFER_FROM_COLLECTION_ACCOUNT'])
            ->select([
                'transaction.id',
                'transaction_reference',
                'transaction.payer_id',
                'transaction.payer_email',
                'transaction.paying_amount',
                'transaction.currency',
                'transaction.payment_method_id',
                'transaction.payer_bank_name',
                'transaction.status',
                'transaction.bank_stan',
                'transaction.bank_rrn',
                'transaction.payment_type_description',
                'transaction.linked_tran_id',
                'transaction.fund_transfer_type',
                'transaction.payment_processor',
                'transaction.fee',
                'transaction.final_payee_account_number',
                'transaction.payee_account_number',
                'transaction.payer_account_number',
                'transaction.bank_reference_id',
                'transaction.created_at',
                'transaction.bank_response',
                'transaction.original_amount',
                'transaction.payer_login_id',
                'transaction.payer_reference',
                'transaction.beneficiary_reference',
                'transaction.payee_name',
                'transaction.payee_bank_name',
                'transaction.payee_account_name',
                'app_user.nic',
                'app_user.phone_number',

            ])
            ->leftJoin('app_user', 'transaction.payer_id', '=', 'app_user.username')
            ->orderBy($this->sortField ?? 'id', $this->sortField == 'id' ? 'DESC' : $this->sortDirection);


//        if ($this->filterFullTranId != null) {
//            $tranData->where(function ($q) {
//                $q->where('transaction.id', $this->filterFullTranId)
//                    ->orWhere('transaction.linked_tran_id', $this->filterFullTranId);
//            });
//        }

        return $tranData;
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'nic',
                'phone_number'
            ]
        ];
    }

    public function addColumns(): PowerGridColumns
    {

        return PowerGrid::eloquent();
//            ->addColumn('created_at_formatted', function (Transaction $model) {
//                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
//            })
//            ->addColumn('paying_amount', function ($data) {
//                return number_format($data->paying_amount, 2);
//            })
//            ->addColumn('original_amount', function ($data) {
//                return number_format($data->original_amount, 2);
//                if (($data->original_amount == 0) && ($data->paying_amount > 0)) {
//                    return number_format($data->paying_amount - $data->fee, 2);
//                }
//                return number_format($data->original_amount, 2);
//            })
//            ->addColumn('fee', function ($data) {
//                return number_format($data->fee, 2);
//            })
//            ->addColumn('fund_transfer_type_formated', function ($data) {
//                return ucfirst(strtolower(str_replace('_', ' ', $data->fund_transfer_type)));
//            })
//            ->addColumn('final_payee_account_number', function ($data) {
//                return $data->final_payee_account_number ?? $data->payee_account_number;
//            })
//            ->addColumn('status', function ($model) {
//                if ($model->status == Transaction::SUCCESS) {
//                    return Blade::render('<x-button positive 2xs label="Success" />');
//                } elseif ($model->status == Transaction::FAILED) {
//                    return Blade::render('<x-button red 2xs label="Failed" />');
//                } elseif ($model->status == Transaction::PENDING) {
//                    return Blade::render('<x-button warning 2xs label="Pending" />');
//                } elseif ($model->status == Transaction::INCOMPLETE) {
//                    return Blade::render('<x-button zinc 2xs label="Incomplet" />');
//                } elseif ($model->status == Transaction::REFUNDED) {
//                    return Blade::render('<x-button 2xs pink label="Refunded" />');
//                }
//                return Blade::render('<x-button 2xs label="' . $model->status . '"/>');
//            })
//            ->addColumn('status_values', function ($model) {
//                if ($model->status == Transaction::SUCCESS) {
//                    return "Success";
//                } elseif ($model->status == Transaction::FAILED) {
//                    return "Failed";
//                } elseif ($model->status == Transaction::PENDING) {
//                    return "Pending";
//                } elseif ($model->status == Transaction::INCOMPLETE) {
//                    return "Incomplete";
//                } elseif ($model->status == Transaction::REFUNDED) {
//                    return "Refunded";
//                }
//                return $model->status;
//            })->addColumn('payer_login_id', function ($model) {
//                return $model->payer_login_id;
//            });
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
                ->title('Payer Account Number')
                ->field('payer_account_number'),
            Column::add()
                ->title('Payment Type Description')
                ->field('payment_type_description'),
            Column::add()
                ->title('Fund Transfer Type')
                ->field('fund_transfer_type_formated'),
            Column::add()
                ->title('Status')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:150px')
                ->bodyAttribute('text-center')
                ->field('status'),
            Column::add()
                ->title('Status')
                ->hidden()
                ->visibleInExport(true)
                ->field('status_values'),
            Column::add()
                ->title('Payment Processor')
                ->field('payment_processor'),
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
                ->title('Payee Name')
                ->field('payee_account_name'),
            Column::add()
                ->title('Payee Bank Name')
                ->field('payee_bank_name'),
            Column::add()
                ->title('Final Payee Account Number')
                ->field('final_payee_account_number'),
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
                ->title('Bank Response')
                ->field('bank_response'),
            Column::add()
                ->title('Payer Reference ')
                ->field('payer_reference'),
            Column::add()
                ->title('Beneficiary Reference ')
                ->field('beneficiary_reference'),
        ];
    }

    public function filters(): array
    {
        return [
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
