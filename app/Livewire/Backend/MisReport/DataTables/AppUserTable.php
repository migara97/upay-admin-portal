<?php

namespace App\Livewire\Backend\MisReport\DataTables;

use App\Models\Backend\AppUser;
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

final class AppUserTable extends PowerGridComponent
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
        return AppUser::query();
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('name_lower', fn (AppUser $model) => strtolower(e($model->name)))
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (AppUser $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Name')
                ->field('full_name')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('User ID')
                ->field('name')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Mobile')
                ->field('phone_number')
                ->searchable(),

            Column::add()
                ->title('Email')
                ->field('email')
                ->searchable()
                ->sortable(),


            Column::add()
                ->title('NIC')
                ->field('nic')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('City')
                ->field('city')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Account Status')
                ->field('status')
                ->headerAttribute('text-center', 'width:100px')
                ->bodyAttribute('text-center')
                ->visibleInExport(false),

            Column::add()
                ->title('Status')
                ->field('status_export')
                ->hidden()
                ->visibleInExport(true),

            Column::add()
                ->title('Customer Type')
                ->field('customer_type')
                ->searchable()
                ->sortable(),


            Column::add()
                ->title('User Group')
                ->field('group_name')
                ->searchable()
                ->visibleInExport(true),

            Column::add()
                ->title('Created at')
                ->field('created_at')
                ->searchable()
                ->sortable(),

            // Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            // Filter::inputText('name'),
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    // public function actions(\App\Models\Backend\AppUser $row): array
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
    public function actionRules(\App\Models\Backend\AppUser $row): array
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
