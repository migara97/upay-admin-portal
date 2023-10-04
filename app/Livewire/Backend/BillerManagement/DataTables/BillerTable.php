<?php

namespace App\Livewire\Backend\BillerManagement\DataTables;

use App\Models\Backend\Biller;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
use WireUi\Traits\Actions;

final class BillerTable extends PowerGridComponent
{
    use WithExport;
    use Actions;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        if (Auth::user()->can('add-provider')) {
        return [
            Button::add('create')
                ->slot(__('Add New Provider'))
                ->class('flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                        text-sm font-medium text-white bg-emerald-700 hover:bg-emerald-600 focus:outline-none
                        focus:ring-2 focus:ring-offset-2 focus:ring-emerald-700 cursor-pointer')
                ->dispatch('create-provider', [])
        ];
        } else {
            return [];
        }
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
        return PowerGrid::columns()
        ->addColumn('provider_image', function (Biller $biller) {
            return Blade::render('<img src="' . env('APP_RESOURCE_URL') . $biller->provider_image . '" alt="' . $biller->provider_image . '" /><x-button icon="pencil" label="Update" wire:click="updateProviderImage(' . $biller->id . ')" primary flat xs />');
        })
        ->addColumn('state', function (Biller $biller) {
            if ($biller->state) {
                return Blade::render('<x-button.circle positive 2xs label=" " />');
            }
            return Blade::render('<x-button.circle 2xs label=" "/>');
        })
        ->addColumn('is_mobile', function (Biller $biller) {
            if ($biller->is_mobile) {
                return Blade::render('<x-button.circle positive 2xs label=" " />');
            }
            return Blade::render('<x-button.circle 2xs label=" "/>');
        })
        ->addColumn('is_num', function (Biller $biller) {
            if ($biller->is_num) {
                return Blade::render('<x-button.circle positive 2xs label=" " />');
            }
            return Blade::render('<x-button.circle 2xs label=" "/>');
        })
        ->addColumn('bank_id', function (Biller $biller) {
            return $biller->bank ? $biller->bank->name : $biller->bank_id;
        })
        ->addColumn('max_amount', function (Biller $biller) {
            return number_format($biller->max_amount, 2);
        })
        ->addColumn('min_amount', function (Biller $biller) {
            return number_format($biller->min_amount, 2);
        });
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

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('biller_code'),
            Filter::inputText('biller_name'),
            Filter::inputText('category_id'),
            Filter::boolean('is_mobile'),
            Filter::boolean('is_num'),
            Filter::inputText('provider_image'),
            Filter::inputText('label'),
            Filter::inputText('place_holder'),
            Filter::inputText('account_number'),

            Filter::boolean('state')->label('Active', 'Inactive'),
        ];
    }
    

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(\App\Models\Backend\Biller $row): array
    {
        return [
            // Button::add('edit')
            //     ->slot('Edit: '.$row->id)
            //     ->id()
            //     ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
            //     ->dispatch('edit', ['rowId' => $row->id])

            Button::add('edit')
                ->slot('Edit')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm sm')
                ->dispatch('edit-provider', ['id' => $row->id]),
        ];
    }

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

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(), 
            [
                'create-provider' => 'createProvider',
                'edit-provider' => 'editProvider',
                'toggle-provider' => 'toggleProvider',
                'reload-biller-table' => '$refresh',
            ]);
    }

    public function createProvider()
    {
        $this->dispatch('CreateProvider');
    }

    public function editProvider($id)
    {
        $this->dispatch('EditProvider', $id);
    }

    public function updateProviderImage($id)
    {
        $this->dispatch('UpdateProviderImage', ['provider' => $id]);
    }

    public function makeToggle($data)
    {
        $this->dispatch('ToggleProvider', $data);
    }

    public function cancelToggle()
    {
        $this->dispatch('reload-biller-table');
    }


    public function toggleProvider($data)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => ($data['value'] == 1 ? 'Enable' : 'Disable') . ' this provider?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, save it',
                'method' => 'makeToggle',
                'params' => $data,
            ],
            'reject' => [
                'label' => 'No, cancel',
                'method' => 'cancelToggle',
            ],
        ]);
    }
}
