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
             viewBox="-30 0 173 46">
            <defs>
                <pattern id="pattern" width="1" height="1" viewBox="-11.669 -4.565 207.337 55.13">
                    <image width="184" height="46"
                           xlink:href="{{URL::asset('/image/Upay-Logo.png')}}"/>
                </pattern>
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

            <!-- Transactions -->
            <x-backend.menu-item title='All Transactions' :hasSubMenu="true"
                                 is-active="{{ request()->is('admin/transactions*') }}" label="All Transactions">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24">
                        <path id="path_pay" data-name="path_pay"
                              d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                              fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"/>
                    </svg>
                </x-slot:icon>

                <a href="{{ route('admin.transactions.payment') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/transactions/payment') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Payments - UT -GOV
                </a>

                <a href="{{ route('admin.transactions.lanka-qr') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/transactions/lanka-qr') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    LankaQR
                </a>

                <a href="{{ route('admin.transactions.fund-transfer') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/transactions/fund-transfer') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Fund Transfers
                </a>

                <a href="{{ route('admin.transactions.card-settlement') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/transactions/card-settlement') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Card Settlements
                </a>

                <a href="{{ route('admin.transactions.refund') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/transactions/refund') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Refunds
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

                <a href="{{ route('admin.reports.appUser') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/reports/app-user*') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Customer List
                </a>

                <a href="{{ route('admin.reports.admin-creation') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/reports/admin-users') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    All Admin Users
                </a>

            </x-backend.menu-item>

            <!-- Management -->
            <x-backend.menu-item title='Management' :hasSubMenu="true"
                                 is-active="{{ request()->is('admin/management*') }}" label="Management">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
                    </svg>
                </x-slot:icon>

                <a href="{{ route('admin.management.app-user') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/management/app-user') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    App Users
                </a>

            </x-backend.menu-item>

            <!-- Service Provider Management -->
            <x-backend.menu-item title='Biller Management' :hasSubMenu="true"
                                 is-active="{{ request()->is('admin/providers*') }}" label="Biller Management">
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path id="Path_6" data-name="Path 6"
                              d="M7,21a4,4,0,0,1-4-4V5A2,2,0,0,1,5,3H9a2,2,0,0,1,2,2V17A4,4,0,0,1,7,21Zm0,0H19a2,2,0,0,0,2-2V15a2,2,0,0,0-2-2H16.657M11,7.343l1.657-1.657a2,2,0,0,1,2.828,0l2.829,2.829a2,2,0,0,1,0,2.828L9.828,19.828M7,17h.01"
                              transform="translate(-2 -2)" fill="none" stroke="#000" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" opacity="0.631"/>
                    </svg>
                </x-slot:icon>

                <a href="" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/providers/category') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Provider Categories
                </a>

                <a href="{{ route('admin.providers.biller') }}" role="menuitem"
                   class="block p-1 text-xs text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700 {{ request()->is('admin/providers/biller') ? 'active-menu' : '' }}"
                   :class="{ 'lg:hidden': !isSidebarOpen }">
                    Providers
                </a>

            </x-backend.menu-item>


            <div style="margin-bottom: 2rem;"></div>
        </ul>
    </nav>

</aside>
