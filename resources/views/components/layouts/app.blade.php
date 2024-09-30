<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Dress Zone' }}</title>
</head>

<body class="bg-cyan-50 dark:bg-slate-800">
    @livewire('partials.navbar')
    <main>
        {{ $slot }}
    </main>
    <livewire:utilities.toast-notification />
    @livewire('partials.footer')
    @livewireScripts
</body>

</html>
