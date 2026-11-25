<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon.png') }}">
    <meta property="og:site_name" content="{{ config('app.name', 'GetPaid') }}">
    <meta property="og:title" content="@yield('title', 'GetPaid') · {{ config('app.name', 'GetPaid') }}">
    <meta property="og:description" content="Instant UPI payments directly into your bank account with zero transaction fees.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    {{-- Google Fonts: Inter (sans) + JetBrains Mono (code) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased">
    <a href="#main-content" class="skip-link">Skip to content</a>
    @yield('body')
    @stack('scripts')
</body>
</html>
