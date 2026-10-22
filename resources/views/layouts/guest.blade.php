<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') · {{ config('app.name', 'Sistem Penjualan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full items-center justify-center bg-gradient-to-br from-slate-100 via-slate-50 to-blue-100 p-4 font-sans text-slate-700 antialiased">
    @yield('content')
</body>
</html>
