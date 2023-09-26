@props(['title', 'hasSubMenu' => false, 'isActive' => false, 'route'=> null, 'label' => null])

<div x-data="{open: @js($isActive), hasSubMenu: @js($hasSubMenu) }" class="menu_icon" style="position: relative;">
    <a href="{{ $route && !$isActive ? route($route) : 'javascript:void(0)'}}" @click="hasSubMenu ?  open = !open : null; isSidebarOpen = true;"
       class="flex items-center p-2 text-gray-500 transition-colors rounded-md bg-primary-101 dark:text-light
                     hover:bg-primary-100 dark:hover:bg-primary {{ $isActive ? 'active-text-red ' : ''}}"
       :class="{'justify-center': !isSidebarOpen, {{ $isActive ? '\'bg-gray-200\': !isSidebarOpen' : ''}} }"
       role="button"
       aria-haspopup="true" :aria-expanded="(open) ? 'true' : 'false'">

        <span aria-hidden="true">
            {{ $icon }}
        </span>

        <span class="ml-2 text-xs" :class="{ 'lg:hidden': !isSidebarOpen }"> {{ $title }}</span>

        @if ($hasSubMenu)
            <span aria-hidden="true" class="ml-auto" :class="{ 'lg:hidden': !isSidebarOpen }">
                <!-- active class 'rotate-180' -->
                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </span>
        @endif

    </a>

    @if ($hasSubMenu)
        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Components">
            <!-- active & hover classes 'text-gray-700 dark:text-light' -->
            <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
            {{ $slot }}

        </div>
    @endif

    @if($label != null)
        <div class="tooltip tooltip-label" style="position: fixed; overflow: visible; z-index: 9999999 !important;">
            <small>{{$label}} </small>
        </div>
    @endif
</div>