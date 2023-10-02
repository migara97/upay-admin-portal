<div>
    <div>
        <x-backend.content-header title="Provider Management" />

        <x-card class="relative">
            <livewire:backend.biller-management.data-tables.biller-table />
        </x-card>

        <x-modal.card title="{{ $modelTitle }}" wire:model.defer="providerCreateModal" max-width="3xl" :hide-close="true">
            <x-errors only="generalError" title="Provider adding failed." />
            <form action="">

                <div
                    class="grid grid-cols-3 {{ $category == env('CATEGORY_GOV_ID') ? 'grid-rows-1' : 'grid-rows-2' }} gap-2 items-start">

                    <x-select class="col-span-2" label="Select Category" placeholder="Select a category" :searchable="true"
                        :options="$categories" option-label="name" option-value="id" wire:model="category"
                        wire:change="categoryChangedCallback" />

                    <x-input wi label="{{ $category == env('CATEGORY_GOV_ID') ? 'Institute ID' : 'Provider Code' }}"
                        placeholder="{{ $category == env('CATEGORY_GOV_ID') ? 'Institute ID' : 'Provider Code' }}"
                        wire:model="providerCode" />

                    <x-input label="Name" style="margin-top: 0%; margin-bottom: auto"
                        placeholder="{{ $category == env('CATEGORY_GOV_ID') ? 'Institute Name' : 'Provider Name' }}"
                        wire:model="providerName" />

                    @if ($category != env('CATEGORY_GOV_ID'))
                        @if ($operationMethod === 'store')
                            <x-input type="number" label="Biller Fee" placeholder="0.00"
                                wire:model.defer="convenienceFee" min="0" />
                        @endif
                        <div class="">
                            <x-input type="number" label="Max Length" placeholder="0" wire:model.defer="maxLength"
                                min="0" />
                        </div>
                        <div class="">
                            <x-input type="number" label="Min Length" placeholder="0" wire:model.defer="minLength"
                                min="0" />
                        </div>
                    @endif
                    @if ($operationMethod === 'store')
                        <div class="col-span-1 flex-row">

                            @if ($icon)
                                <img class="col-span-1" src="{{ $icon->temporaryUrl() }}" width="80">
                            @endif
                            <x-errors only="imageError" title="Image upload failed." />
                            <x-input class="col-span-1" type="file" accept="image/png, image/jpeg" label="Icon"
                                placeholder="0" wire:model.defer="icon" />
                        </div>
                    @endif


                    @if ($category != env('CATEGORY_GOV_ID'))
                        <x-input label="Account Number" placeholder="Account no" wire:model.defer="accountNo" />

                        <x-input type="number" label="Max Amount (LKR)" placeholder="0.00" wire:model.defer="maxAmount"
                            min="0" />
                        <x-input type="number" label="Min Amount (LKR)" placeholder="9999.00"
                            wire:model.defer="minAmount" min="0" />

                        <div class="col-span-2">
                            <x-input label="Placeholder" placeholder="Placeholder" wire:model.defer="placeholder"
                                name="placeholder" />
                        </div>
                        <div class="">
                            <x-select
                                class="sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm cursor-pointer "
                                label="Label" placeholder="Select a label" :searchable="false" :options="$labels"
                                option-label="name" option-value="name" wire:model="label" />
                        </div>

                        <br>

                        <div class="">
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="mobile" wire:model="isMobile"
                                    class="form-checkbox h-6 w-6 text-green-500">
                                <span class="ml-3 text-sm">Mobile</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="numeric" wire:model="isNumber"
                                    class="form-checkbox h-6 w-6 text-green-500">
                                <span class="ml-3 text-sm">Numeric</span>
                            </label>
                        </div>
                    @endif

                    <div class="">
                        <label class="inline-flex items-center">
                            <input type="checkbox" value="status" wire:model="status"
                                class="form-checkbox h-6 w-6 text-green-500" checked>
                            <span class="ml-3 text-sm">Active</span>
                        </label>
                    </div>
                </div>
            </form>
            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <x-button flat label="Cancel" wire:click="closeModal" />
                    <x-button primary label="{{ ucwords($modelBtnTitle) }}" wire:click="{{ $operationMethod }}" />
                </div>
            </x-slot>
        </x-modal.card>
    </div>
</div>
