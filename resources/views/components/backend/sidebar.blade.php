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

            <!-- Admin User Management -->
            <x-backend.menu-item title='Admin User Management' :hasSubMenu="true"
                                 is-active="{{ request()->is('admin/user-management*') }}"
                                 label="Admin User Management">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                        <path id="Path_2" data-name="Path 2"
                              d="M17.571,7A4.314,4.314,0,0,1,13,11,4.314,4.314,0,0,1,8.429,7,4.314,4.314,0,0,1,13,3a4.314,4.314,0,0,1,4.571,4ZM13,14c-4.418,0-8,3.134-8,7H21C21,17.134,17.418,14,13,14Z"
                              transform="translate(-4 -2)" fill="none" stroke="#000" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" opacity="0.631"/>
                    </svg>
                </x-slot:icon>

                <a href="{{ route('admin.user-managment.user') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/user-management/users') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Manage User
                </a>
            </x-backend.menu-item>

            <!-- Role management -->
            <x-backend.menu-item title='Role Management' :hasSubMenu="true"
                                 is-active="{{ request()->is('admin/role-management*') }}" label="Role Management">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path id="Path_3" data-name="Path 3"
                              d="M13,6.25V4m0,2.25a2.25,2.25,0,1,0,0,4.5m0-4.5a2.25,2.25,0,1,1,0,4.5m-6.75,9a2.25,2.25,0,1,0,0-4.5m0,4.5a2.25,2.25,0,1,1,0-4.5m0,4.5V22m0-6.75V4M13,10.75V22m6.75-2.25a2.25,2.25,0,1,0,0-4.5m0,4.5a2.25,2.25,0,1,1,0-4.5m0,4.5V22m0-6.75V4"
                              transform="translate(-3 -3)" fill="none" stroke="#000" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" opacity="0.631"/>
                    </svg>
                </x-slot:icon>

                <a href="{{ route('admin.role-managment.role') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/role-management/roles') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Manage Roles
                </a>
            </x-backend.menu-item>

            <!-- MIS Reports -->
            <x-backend.menu-item title='MIS Reports' :hasSubMenu="true"
                                 is-active="{{ request()->is('admin/reports*') }}" label="MIS Reports">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path id="Path_7" data-name="Path 7"
                              d="M10.143,17V15M14,17V13m3.857,4V11m2.571,10H7.571A2.34,2.34,0,0,1,5,19V5A2.34,2.34,0,0,1,7.571,3h7.182a1.492,1.492,0,0,1,.909.293l6.961,5.414A.9.9,0,0,1,23,9.414V19A2.34,2.34,0,0,1,20.429,21Z"
                              transform="translate(-4 -2)" fill="none" stroke="#000" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" opacity="0.631"/>
                    </svg>
                </x-slot:icon>

                <a href="{{ route('admin.reports.admin-creation') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/reports/admin-users') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    All Admin Users
                </a>

            </x-backend.menu-item>

            <div style="margin-bottom: 2rem;"></div>
        </ul>
    </nav>

</aside>
