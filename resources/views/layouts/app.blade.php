<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('meta_description', config('app.name', 'UPay Admin Portal') )">
    <meta name="author" content="@yield('meta_author', 'Upay PLC')">
    <title>{{ config('app.name', 'UPay Admin Portal') }}</title>


    <!-- Styles -->
    @stack('before-styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
    @stack('after-styles')

</head>

<body class="font-sans h-full">

    <x-dialog/>
    <x-notifications />

    <div class="flex h-screen overflow-y-hidden bg-white dark:bg-slate-900" x-data="setup()"
     x-init="$refs.loading.classList.add('hidden')">

    <div x-ref="loading"
         class="fixed inset-0 z-50 flex items-center justify-center text-white bg-black bg-opacity-50"
         style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">

        <div class="loadingio-spinner-ripple-uigywywh8uh">
            <div class="ldio-p8gmbj4kg">
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <!-- Sidebar backdrop -->
    <div x-show.in.out.opacity="isSidebarOpen" class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"
         style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">

    </div>
    <!-- Sidebar -->
    <x-backend.sidebar/>

    <div class="flex flex-col flex-1 h-full overflow-hidden" style="position: relative;">
        <!-- Navbar -->
        <x-backend.header/>
        <!-- Main content -->
        <main class="flex-1 max-h-full p-5 overflow-hidden overflow-y-scroll">
            {{ $slot }}
        </main>
        <!-- Main footer -->
        <x-backend.footer/>
    </div>

</div>

<!-- scripts -->
@stack('before-scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
<script>
    var labelState = window.localStorage.getItem('isSidebarOpen')
    changeTooltipStatus(labelState);

    const setup = () => {
        function getSidebarStateFromLocalStorage() {
            // if it already there, use it
            if (window.localStorage.getItem('isSidebarOpen')) {
                return JSON.parse(window.localStorage.getItem('isSidebarOpen'))
            }

            // else return the initial state you want
            return (
                false
            )
        }

        function setSidebarStateToLocalStorage(value) {
            window.localStorage.setItem('isSidebarOpen', value)
        }

        return {
            loading: true,
            isSidebarOpen: getSidebarStateFromLocalStorage(),
            toggleSidbarMenu() {
                this.isSidebarOpen = !this.isSidebarOpen
                setSidebarStateToLocalStorage(this.isSidebarOpen)

                //disable tooltip
                changeTooltipStatus(this.isSidebarOpen);

            },
            isSettingsPanelOpen: false,
            isSearchBoxOpen: false,
        }
    }

    function changeTooltipStatus(status){
        var labels = document.getElementsByClassName("tooltip-label");

        if(status){
            // label.classList.remove("tooltip");
            for(let i=0; i < labels.length; i++){
                labels[i].classList.remove("tooltip");
            }
        }else{
            for(let i=0; i < labels.length; i++){
                labels[i].classList.add("tooltip");
            }
        }
    }
</script>
@livewireScripts
@wireUiScripts


@stack('after-scripts')
</body>

</html>