<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('meta_description', config('app.name', 'UPay Admin Portal') )">
    <meta name="author" content="@yield('meta_author', 'Seylan PLC')">
    <title>{{ config('app.name', 'UPay Admin Portal') }}</title>


    <!-- Styles -->
    @stack('before-styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
    @stack('after-styles')

</head>

<body class="font-sans h-full">
<div class="min-h-screen bg-white dark:bg-slate-900">
    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

<!-- scripts -->
@stack('before-scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@livewireScripts
@wireUiScripts
@stack('after-scripts')
</body>

</html>
