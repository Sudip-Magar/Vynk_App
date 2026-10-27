<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main
        class=" bg-black/40 bg-blend-multiply bg-cover bg-center min-h-dvh w-full flex items-center justify-center p-4"
        style="background-image: url('{{ asset('assets/auth/auth_background.jpg') }}')">
        <div class="w-full max-w-md rounded-2xl border border-white/20 bg-white/10 backdrop-blur-md p-6 sm:p-8 text-white shadow-lg">
            {{ $slot }}
        </div>
    </main>

    {{--  TOAST area --}}
    <x-toast />
</body>

</html>
