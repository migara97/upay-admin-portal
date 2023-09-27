@props(['title', 'button' => '', 'action' => '', 'actionTitle' => ''])
<div
    class="flex flex-col items-start justify-between pb-3 space-y-4 border-b lg:items-center lg:space-y-0 lg:flex-row mb-4">
    <h1 class="text-2xl font-semibold whitespace-nowrap">{{ $title }}
        @if($button != '')
            <x-button right-icon="reply" class="ml-3" href="{{route($button)}}" xs outline secondary label="Back" />
        @endif

        @if($action != '')
            <x-button icon="refresh" class="ml-3" wire:click="{{ $action }}" xs outline secondary label="{{ $actionTitle }}" />
        @endif
    </h1>
</div>
