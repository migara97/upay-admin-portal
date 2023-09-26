<aside x-cloak x-transition:enter="transition transform duration-300"
       x-transition:enter-start="-translate-x-full opacity-30  ease-in"
       x-transition:enter-end="translate-x-0 opacity-100 ease-out"
       x-transition:leave="transition transform duration-300"
       x-transition:leave-start="translate-x-0 opacity-100 ease-out"
       x-transition:leave-end="-translate-x-full opacity-0 ease-in"
       class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen  transition-all transform bg-white border-r shadow-lg lg:z-auto lg:static lg:shadow-none"
       :class="{ '-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen }">
    <!-- sidebar header -->
    <div class="flex items-center justify-between flex-shrink-0 p-2" :class="{ 'lg:justify-center': !isSidebarOpen }">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="173" height="46"
             viewBox="0 0 173 46">
            <defs>
                
            </defs>
            <rect id="red" width="173" height="46" fill="url(#pattern)"/>
        </svg>

        <button @click="toggleSidbarMenu()" class="p-2 rounded-md lg:hidden">
            <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>

        </button>
    </div>
    <!-- Sidebar links -->
    <nav class="flex-1 hover:overflow-y-auto">
        <ul class="p-2  space-y-2">

            {{-- Dashboard --}}
            <x-backend.menu-item title='Dashboard' :hasSubMenu="false" route="admin.dashboard" label="Dashboard"
                                 is-active="{{ request()->is('admin/dashboard') }}">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20.828" height="20" viewBox="0 0 20.828 20">
                        <path id="Path_1" data-name="Path 1"
                              d="M3,12l2-2m0,0,7-7,7,7M5,10V20a1,1,0,0,0,1,1H9M19,10l2,2m-2-2V20a1,1,0,0,1-1,1H15M9,21a1,1,0,0,0,1-1V16a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1v4a1,1,0,0,0,1,1M9,21h6"
                              transform="translate(-1.586 -2)" fill="none" stroke="#000" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" opacity="0.631"/>
                    </svg>
                </x-slot:icon>
            </x-backend.menu-item>

            <div style="margin-bottom: 2rem;"></div>
        </ul>
    </nav>

</aside>