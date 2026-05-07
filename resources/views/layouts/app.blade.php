<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Treasurer\'s Office') }}</title>

        <!-- Favicon / Tab Logo -->
        <link rel="icon" type="image/png" href="{{ asset('image/logo1.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased text-slate-100 midnight-bg">
        <div class="min-h-screen bg-gradient-to-b from-midnight-950 via-midnight-900 to-midnight-950">
            @include('sunrise-nav-bar')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-midnight-800/80 backdrop-blur-md border-b border-slate-700/50 shadow-lg lg:hidden">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="bg-gradient-to-b from-midnight-950 via-midnight-900 to-midnight-950">
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
