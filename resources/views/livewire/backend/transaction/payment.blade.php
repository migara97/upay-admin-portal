<div>
    <div>
        <x-backend.content-header title="Payments - UT - GOV" action="{{ $filterId != null ? 'clearFulTranFilter' : '' }}" actionTitle="Clear Filter" />
    </div>
    <x-card title="" class="relative">
        <livewire:backend.transaction.data-tables.payment-table />
    </x-card>
</div>
