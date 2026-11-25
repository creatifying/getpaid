@props(['dark' => false, 'iconOnly' => false, 'height' => 'h-8 sm:h-9'])
<span {{ $attributes->class(['brand-logo', 'brand-logo-dark' => $dark]) }}>
    <img src="{{ asset('images/getpaid/branding/getpaid-brand-symbol-transparent_1254x1254.webp') }}" class="{{ $height }}" width="36" height="36" alt="{{ $iconOnly ? config('app.name', 'GetPaid') : '' }}">
    @unless ($iconOnly)
        <span class="brand-wordmark">get<span>paid</span><span class="sr-only"> · {{ config('app.name', 'GetPaid') }}</span></span>
    @endunless
</span>
