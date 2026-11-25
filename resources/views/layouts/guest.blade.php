@extends('layouts.base')

@section('body')
<div class="auth-shell min-h-full grid lg:grid-cols-2">
    {{-- Brand panel --}}
    <div class="auth-brand-panel relative hidden lg:flex flex-col justify-between overflow-hidden bg-brand-950 p-12 text-white">
        <a href="{{ route('home') }}" class="relative"><x-logo dark /></a>

        <div class="relative max-w-md">
            <div class="auth-overline">YOUR BUSINESS. YOUR PAYMENTS. YOUR BANK.</div>
            <h2>Your next chapter<br>starts with a<br>better way to get paid.</h2>
            <p class="mt-4 text-slate-300">Direct UPI payments, clear order tracking, and the tools to keep your business moving.</p>
            <ul class="mt-8 space-y-3 text-sm text-slate-200">
                @foreach (['Money goes directly to your own UPI ID', 'Works with GPay, PhonePe, Paytm, BHIM and every UPI app', 'Simple REST API and webhooks for developers'] as $point)
                    <li class="flex items-center gap-3"><span class="grid place-items-center w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400"><x-icon name="check" class="w-3.5 h-3.5" /></span>{{ $point }}</li>
                @endforeach
            </ul>
        </div>

        <div class="relative text-xs text-slate-400">© {{ date('Y') }} {{ config('app.name') }}</div>
    </div>

    {{-- Form --}}
    <main id="main-content" class="auth-form-panel flex flex-col justify-center px-6 py-12 sm:px-12">
        <div class="w-full max-w-sm mx-auto">
            <a href="{{ route('home') }}" class="lg:hidden inline-block mb-10"><x-logo /></a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">@yield('title')</h1>
            @hasSection('subtitle')<p class="mt-2 text-sm text-slate-500">@yield('subtitle')</p>@endif

            <div class="mt-8">
                {{-- Register shows errors next to each field; login has only one general error. --}}
                @if ($errors->any() && ! request()->routeIs('register'))
                    <div class="mb-5 flex items-start gap-2 rounded-lg bg-red-50 ring-1 ring-red-200 px-3 py-2.5 text-sm text-red-700">
                        <x-icon name="alert" class="w-5 h-5" /> {{ $errors->first() }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </main>
</div>
@endsection
