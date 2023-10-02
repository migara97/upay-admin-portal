<?php

namespace App\Livewire\Backend\BillerManagement\DataTables;

use App\Models\Backend\BillerCategory;
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

final class BillerCategoryTable extends PowerGridComponent
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
                ->slot(__('Add New Category'))
                ->class('flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                        text-sm font-medium text-white bg-emerald-700 hover:bg-emerald-600 focus:outline-none
                        focus:ring-2 focus:ring-offset-2 focus:ring-emerald-700 cursor-pointer')
                ->openModal('create-provider', [])
        ];
    }

    public function datasource(): Builder
    {
        return BillerCategory::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('category_order')
            ->addColumn('category_status')
            ->addColumn('name')

           /** Example of custom column using a closure **/
            ->addColumn('name_lower', fn (BillerCategory $model) => strtolower(e($model->name)))
;
    }

    public function columns(): array
    {
        return [
            Column::add()->title('id')->field('id')->sortable(),
            Column::add()->title('Category Id')->field('category_id')->searchable()->sortable()->headerAttribute('', 'width: 10rem'),
            Column::add()->title('Name')->field('name')->searchable()->sortable(),
            Column::add()->title('Status')->field('category_status')->visibleInExport(false),
            Column::add()->title('Status')->field('category_status_export')->hidden()->visibleInExport(true),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

//    public function actions(\App\Models\Backend\BillerCategory $row): array
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