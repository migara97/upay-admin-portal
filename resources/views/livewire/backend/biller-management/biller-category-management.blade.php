<div>
    <div>
        <x-backend.content-header title="Provider Category Management"/>

        <x-card class="relative">
            <livewire:backend.biller-management.data-tables.biller-category-table/>
        </x-card>

        <x-modal.card title="{{ $modelTitle }}" wire:model.defer="categoryCreateModal" max-width="2xl"
                      :hide-close="true"
                      x-on:close='$wire.closeModal()'>

            <x-errors only="generalError" title="Category adding failed."/>

            <div class="grid grid-flow-row-dense grid-cols-3 grid-rows-2 gap-2">

                <x-input label="Category Id" placeholder="Category Id" wire:model="categoryId"/>

                <div class="sm:col-span-2">
                    <x-input label="Name" placeholder="Category Name" wire:model="categoryName"/>
                </div>

                <x-toggle md wire:model.defer="categoryStatus" value="categoryStatus" left-label="Status" checked/>
            </div>

            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <x-button flat label="Cancel" wire:click="closeModal"/>
                    <x-button primary label="{{ ucwords($modelBtnTitle) }}" wire:click="{{ $operationMethod }}"/>
                </div>
            </x-slot>
        </x-modal.card>

    </div>
</div>
