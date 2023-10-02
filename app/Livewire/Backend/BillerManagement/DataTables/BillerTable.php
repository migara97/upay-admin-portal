<?php

namespace App\Livewire\Backend\BillerManagement\DataTables;

use App\Models\Backend\Biller;
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

final class BillerTable extends PowerGridComponent
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

    public function header(): array
    {
        return [
            Button::add('create')
                ->slot(__('Add New Provider'))
                ->class('flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                        text-sm font-medium text-white bg-emerald-700 hover:bg-emerald-600 focus:outline-none
                        focus:ring-2 focus:ring-offset-2 focus:ring-emerald-700 cursor-pointer')
                ->openModal('create-provider', [])
        ];
    }

    public function datasource(): Builder
    {
        return Biller::query()->orderByDesc('id');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns();
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Id')
                ->field('id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Provider Code')
                ->field('biller_code')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Provider Name')
                ->field('biller_name')
                ->searchable('biller_name')
                ->sortable(),

            Column::add()
                ->title('Category Id')
                ->field('category_id')
                ->bodyAttribute('text-right')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Mobile')
                ->field('is_mobile')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:80px')
                ->bodyAttribute('text-center'),

            Column::add()
                ->title('Mobile')
                ->field('is_mobile_export')
                ->hidden()
                ->visibleInExport(true)
                ->hidden(),

            Column::add()
                ->title('Numeric')
                ->field('is_num')
                ->visibleInExport(false)
                ->headerAttribute('text-center', 'width:80px')
                ->bodyAttribute('text-center'),

            Column::add()
                ->title('Mobile')
                ->hidden()
                ->field('is_num_export')
                ->visibleInExport(true)
                ->hidden(),

            Column::add()
                ->title('Max Length')
                ->field('max_length')
                ->bodyAttribute('', 'text-align: right')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Min Length')
                ->field('min_length')
                ->bodyAttribute('', 'text-align: right')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Icon')
                ->field('provider_image')
                ->searchable()
                ->visibleInExport(false)
                ->sortable(),

            Column::add()
                ->title('Label')
                ->field('label'),

            Column::add()
                ->title('Placeholder')
                ->field('place_holder'),

            Column::add()
                ->title('Status')
                ->field('state')
                ->visibleInExport(false)
                ->bodyAttribute('text-center')
                ->headerAttribute('text-center', 'width:70px'),

            Column::add()
                ->title('Status')
                ->field('state_export')
                ->visibleInExport(true)
                ->hidden()
                ->bodyAttribute('', 'text-align: center'),

            Column::add()
                ->title('Account Number')
                ->field('account_number')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Bank')
                ->field('bank_id')
                ->bodyAttribute('text-nowrap')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Max Amount')
                ->field('max_amount')
                ->bodyAttribute('', 'text-align: right')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Min Amount')
                ->field('min_amount')
                ->bodyAttribute('', 'text-align: right')
                ->searchable()
                ->sortable(),
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

    // public function actions(\App\Models\Backend\Biller $row): array
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
