<div>
    <div>
        <x-backend.content-header title="Role Management"/>

        <x-card class="relative">
            <livewire:backend.user-managment.data-tables.roles-table/>
        </x-card>

        <x-modal.card title="{{ $modelTitle }}" wire:model.defer="roleCreateModal" max-width="4xl" :hide-close="true"
            {{--            x-on:close='$wire.close()'--}}
        >

            <x-errors only="generalError" title="Role {{ __($modelBtnTitle) }} failed."/>

            <div class="grid grid-cols-1 gap-2">
                <x-input label="Name" placeholder="Role Name" wire:model="roleName"/>

                <label class="font-bold">
                    Associated Permissions
                </label>
{{--                <div class="grid grid-cols-3 md:grid-cols-3 gap-2">--}}
{{--                    @foreach ($permissionList as $category => $permissions)--}}
{{--                        <div class="shadow rounded p-2">--}}
{{--                            <label class="font-semibold">{{ $category }}</label>--}}

{{--                            @foreach($permissions as $permission)--}}

{{--                                --}}{{--                        <x-checkbox id="{{ $permission->id }}" value="{{ $permission->id }}"--}}
{{--                                --}}{{--                                    left-label="{{ $permission->name }}" wire:model.defer="permissions"/>--}}

{{--                                <div class="mt-2">--}}
{{--                                    <x-toggle id="{{ $permission['id'] }}" md wire:model.defer="permissions" value="{{ $permission['id'] }}"--}}
{{--                                              label="{{ ucwords(str_replace('-', ' ', $permission['name'])) }}"/>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}

            </div>

            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <x-button flat label="Cancel" wire:click="close"/>
                    <x-button primary label="{{ ucwords($modelBtnTitle) }}" wire:click="{{ $operationMethod }}"/>
                </div>
            </x-slot>
        </x-modal.card>

    </div>

{{--    @if($dualAuthRequired)--}}
{{--        <div class="pt-4 relative">--}}
{{--            <x-card title="Pending Items">--}}
{{--                <livewire:backend.dual-auth.data-tables.dual-auth-table tableName="dualAuthTable" form_name="{{ $formName }}"/>--}}
{{--            </x-card>--}}
{{--        </div>--}}

{{--        <!-- summary model -->--}}
{{--        <x-backend.pending-summary />--}}
{{--    @endif--}}

</div>
