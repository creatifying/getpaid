@extends('layouts.base')
@section('title', 'Pay ₹'.number_format($order->amount, 2).' to '.$order->user->displayName())

@php
    $merchant = $order->user->displayName();
    $checkoutStylesVersion = substr(hash_file('sha256', public_path('css/pay.css')), 0, 12);
    $amount = number_format($order->amount, 2);
    $totalSeconds = max(1, $order->created_at->diffInSeconds($order->expires_at ?? now()->addMinutes(config('gateway.order_expiry_minutes', 15))));
    $apps = [
        ['Google Pay', 'tez://upi/pay',   'text-[#1a73e8]', 'images/upi/gpay.png'],
        ['PhonePe', 'phonepe://pay',   'text-[#5f259f]', 'images/upi/phonepe.png'],
        ['Paytm',   'paytmmp://pay',   'text-[#00baf2]', 'images/upi/paytm.png'],
        ['BHIM',    'bhim://upi/pay',       'text-[#f47920]', 'images/upi/bhim.png'],
        ['CRED',    'credpay://upi/pay', 'text-[#1c1c1c]', 'images/upi/cred.png'],
        ['Navi',    'navi://pay',      'text-[#3f238a]', 'images/upi/navi.png'],
    ];
@endphp

@push('head')
<meta name="robots" content="noindex">
<link rel="stylesheet" href="{{ asset('css/pay.css') }}?v={{ $checkoutStylesVersion }}">
@endpush

@section('body')
<div @class(['checkout-page', 'checkout-direct' => $order->isPending() && ! $order->paymentAccount->isHosted()]) data-checkout-status="{{ $order->status }}">
    <header class="checkout-header">
        <a href="{{ route('home') }}" class="checkout-desktop-brand" aria-label="{{ config('app.name') }} home"><x-logo /></a>
        <a href="{{ route('home') }}" class="checkout-mobile-back" aria-label="Return to {{ config('app.name') }}"><x-icon name="arrow-left" class="w-5 h-5" /></a>
        <x-avatar :name="$merchant" size="w-9 h-9 text-sm" class="checkout-mobile-avatar" aria-hidden="true" />
        <div class="checkout-mobile-merchant"><strong title="{{ $merchant }}">{{ $merchant }}</strong><span><x-icon name="lock" class="w-3 h-3" /> Checkout by <b>{{ config('app.name') }}</b></span></div>
        <span class="checkout-secure"><x-icon name="lock" class="w-3.5 h-3.5" /> Payment checkout</span>
    </header>
    <main id="main-content" class="checkout-main">
        <div class="checkout-sheet">
            <aside class="checkout-summary" aria-label="Order summary">
                <div class="checkout-merchant">
                    <x-avatar :name="$merchant" size="w-11 h-11 text-base" class="checkout-avatar" />
                    <div><span>YOU’RE PAYING</span><h2>{{ $merchant }}</h2></div>
                </div>
                <div class="checkout-amount">
                    <span>{{ $order->status === 'paid' ? 'Amount paid' : 'Total amount' }}</span>
                    <div><span class="currency-symbol">₹</span>{{ $amount }}<span class="currency-code">INR</span></div>
                    @if ($order->note)<p>{{ $order->note }}</p>@endif
                    <span class="amount-caption"><x-icon name="banknotes" class="w-3.5 h-3.5" /> {{ $order->paymentAccount->isHosted() ? 'Continue with your payment provider' : 'Direct to the merchant’s bank' }}</span>
                </div>
                <details class="checkout-order-details" open><summary>Order details <x-icon name="chevron-down" class="w-3.5 h-3.5" /></summary><div class="checkout-receipt">
                    <div class="receipt-heading">ORDER DETAILS <x-icon name="receipt" class="w-4 h-4" /></div>
                    <dl>
                        <div><dt>Order ID</dt><dd class="receipt-mono">{{ $order->order_no }}</dd></div>
                        @if ($order->customer_name)<div><dt>Customer</dt><dd>{{ $order->customer_name }}</dd></div>@endif
                        @if ($order->paymentAccount->upi_id)<div><dt>UPI ID</dt><dd class="receipt-mono">{{ $order->paymentAccount->upi_id }}</dd></div>@endif
                        <div><dt>Payment method</dt><dd>{{ $order->paymentAccount->isHosted() ? 'Hosted checkout' : 'UPI' }}</dd></div>
                    </dl>
                </div></details>
                @if ($order->isPending())
                    <div class="checkout-expiry" role="timer" aria-label="Time remaining to pay">
                        <div class="expiry-ring">
                            <svg viewBox="0 0 36 36" aria-hidden="true"><circle cx="18" cy="18" r="16" fill="none" stroke="#dce6d8" stroke-width="2" /><circle id="ring" cx="18" cy="18" r="16" fill="none" stroke="#27865a" stroke-width="2" stroke-linecap="round" stroke-dasharray="100.5" stroke-dashoffset="0" class="ring-transition" /></svg>
                            <x-icon name="clock" class="w-4 h-4" />
                        </div>
                        <div><span>Time remaining</span><strong id="timer">--:--</strong></div>
                        <span class="expiry-live" aria-hidden="true"></span>
                    </div>
                @else
                    <div class="summary-status summary-status-{{ $order->status }}"><x-icon :name="$order->status === 'paid' ? 'check-circle' : ($order->status === 'review' ? 'shield' : 'clock')" class="w-4 h-4" /><span>{{ match ($order->status) { 'paid' => 'Payment confirmed', 'review' => 'Awaiting merchant confirmation', 'expired' => 'Payment window closed', default => 'Payment not completed' } }}</span></div>
                @endif
                <div class="checkout-assurance"><span><x-icon name="shield" class="w-4 h-4" /></span><p>Your UPI PIN stays in your payment app.<br>Never share it with anyone.</p></div>
            </aside>

            {{-- Action area --}}
            <section class="checkout-action" aria-label="Complete payment">
                @if ($order->status === 'paid')
                    <div role="status" class="checkout-result flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="checkout-success pop grid place-items-center w-20 h-20 rounded-full bg-emerald-500">
                            <svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path class="draw" d="m5 12.5 4.5 4.5L19 7.5" /></svg>
                        </div>
                        <div class="checkout-result-kicker">ALL DONE</div><h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">Payment successful</h1>
                        <p class="mt-2 text-slate-500">₹{{ $amount }} paid to {{ $merchant }}</p>
                        <dl class="mt-8 w-full max-w-xs rounded-xl bg-slate-50 ring-1 ring-slate-200 divide-y divide-slate-200 text-sm text-left">
                            @if ($order->utr)<div class="flex justify-between px-4 py-3"><dt class="text-slate-500">UTR</dt><dd class="font-mono font-medium text-slate-900">{{ $order->utr }}</dd></div>@endif
                            <div class="flex justify-between px-4 py-3"><dt class="text-slate-500">Paid at</dt><dd class="font-medium text-slate-900">{{ $order->paid_at?->format('d M Y, h:i A') }}</dd></div>
                        </dl>
                        <p class="mt-6 text-xs text-slate-400">You can safely close this page.</p>
                    </div>
                @elseif ($order->status === 'review')
                    <div role="status" class="checkout-result flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="checkout-review relative grid place-items-center w-20 h-20 rounded-full bg-sky-50 text-sky-600">
                            <svg class="absolute inset-0 w-20 h-20 animate-spin [animation-duration:2.5s]" viewBox="0 0 80 80" fill="none"><circle cx="40" cy="40" r="38" stroke="currentColor" stroke-opacity=".15" stroke-width="3"/><path d="M78 40A38 38 0 0 0 40 2" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                            <x-icon name="shield" class="w-9 h-9" />
                        </div>
                        <div class="checkout-result-kicker">REFERENCE RECEIVED</div><h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">Verifying your payment</h1>
                        <p class="mt-2 text-sm text-slate-500 max-w-sm">{{ $merchant }} is confirming your UTR with their bank. This page updates automatically once it's approved.</p>
                        <dl class="mt-8 w-full max-w-xs rounded-xl bg-slate-50 ring-1 ring-slate-200 divide-y divide-slate-200 text-sm text-left">
                            <div class="flex justify-between px-4 py-3"><dt class="text-slate-500">Your UTR</dt><dd class="font-mono font-medium text-slate-900">{{ $order->customer_utr }}</dd></div>
                            <div class="flex justify-between px-4 py-3"><dt class="text-slate-500">Submitted</dt><dd class="font-medium text-slate-900">{{ $order->utr_submitted_at?->format('d M, h:i A') }}</dd></div>
                        </dl>
                        <p class="mt-6 text-xs text-slate-400">Don't pay again. You can close this page; the merchant will be notified once it's confirmed.</p>
                    </div>
                @elseif ($order->status === 'expired')
                    <div role="status" class="checkout-result flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="grid place-items-center w-20 h-20 rounded-full bg-slate-100 text-slate-400"><x-icon name="clock" class="w-10 h-10" /></div>
                        <h1 class="mt-6 text-2xl font-bold tracking-tight text-slate-900">Payment link expired</h1>
                        @if ($order->canRecoverLatePayment())
                            <p class="mt-2 text-sm text-slate-500 max-w-sm">Already paid? Don't pay again. We can still check the provider until {{ $order->expires_at->copy()->addHours((int) config('gateway.late_payment_grace_hours', 24))->format('d M, h:i A') }}. This page updates when payment is confirmed.</p>
                        @endif
                        @if ($order->acceptsCustomerUtr())
                            <p class="mt-2 text-sm text-slate-500 max-w-sm">If you already paid, don't pay again — submit your UTR below so {{ $merchant }} can confirm it.</p>
                            @include('pay._utr-form', ['class' => 'checkout-utr mt-8 w-full max-w-sm'])
                        @else
                            <p class="mt-2 text-sm text-slate-500 max-w-xs">Please ask {{ $merchant }} for a new payment link.</p>
                            <div class="mt-8 flex items-start gap-3 rounded-xl bg-amber-50 ring-1 ring-amber-200 px-4 py-3 text-left text-sm text-amber-800 max-w-sm">
                                <x-icon name="alert" class="w-5 h-5 text-amber-600" />
                                <div>If money was debited from your account, don't pay again. Share your UTR with the merchant to confirm the payment.</div>
                            </div>
                        @endif
                    </div>
                @elseif ($order->status === 'failed')
                    <div role="status" class="checkout-result flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="checkout-failed grid place-items-center w-20 h-20 rounded-full bg-red-50 text-red-600"><x-icon name="x" class="w-9 h-9" /></div>
                        <div class="checkout-result-kicker">PAYMENT NOT COMPLETED</div>
                        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">Payment unsuccessful</h1>
                        <p class="mt-3 text-sm text-slate-500 max-w-sm">Please contact {{ $merchant }} for a new payment link.</p>
                        <div class="checkout-notice mt-7"><x-icon name="alert" class="w-4 h-4" /><p>If money was debited, don't pay again. Share your UTR with the merchant so they can check the payment.</p></div>
                    </div>
                @elseif ($order->paymentAccount->isHosted())
                    @php $pgName = $order->paymentAccount->provider === 'phonepe_pg' ? 'PhonePe' : 'Paytm'; @endphp
                    <div class="checkout-hosted flex-1 flex flex-col items-center justify-center text-center py-6">
                        <div class="grid place-items-center w-20 h-20 rounded-2xl {{ $pgName === 'PhonePe' ? 'bg-[#5f259f]' : 'bg-[#00baf2]' }} text-white shadow-lg">
                            <x-icon name="lock" class="w-9 h-9" />
                        </div>
                        <h1 class="mt-6 text-xl font-bold tracking-tight text-slate-900">Pay securely with {{ $pgName }}</h1>
                        <p class="mt-2 text-sm text-slate-500 max-w-sm">You'll complete the payment on {{ $pgName }}'s secure checkout using UPI, card or netbanking, then come back here automatically.</p>

                        @error('checkout')
                            <div class="mt-6 flex items-start gap-2 rounded-lg bg-red-50 ring-1 ring-red-200 px-3 py-2 text-left text-sm text-red-700 max-w-sm">
                                <x-icon name="alert" class="w-5 h-5" /><div>{{ $message }}</div>
                            </div>
                        @enderror

                        <form id="pg-start" data-checkout-submit data-submitting-label="Opening secure checkout…" method="POST" action="{{ route('pay.start', $order) }}" class="mt-8 w-full max-w-sm">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-full"><x-icon name="lock" class="w-5 h-5" /> Pay ₹{{ $amount }} with {{ $pgName }}</button>
                        </form>
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            @foreach ($apps as [$name, $scheme, $color, $logo])
                                <span class="rounded-full bg-slate-50 ring-1 ring-slate-200 px-3 py-1 text-xs font-bold {{ $color }} flex items-center gap-1.5">
                                    <img src="{{ asset($logo) }}" class="w-4 h-4 rounded-sm" alt="{{ $name }}">{{ $name }}
                                </span>
                            @endforeach
                            <span class="rounded-full bg-slate-50 ring-1 ring-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Cards</span>
                            <span class="rounded-full bg-slate-50 ring-1 ring-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Netbanking</span>
                        </div>
                        @if ($order->provider_checkout)
                            <p class="mt-6 text-xs text-slate-500">Already paid? Stay on this page — we're checking with {{ $pgName }} automatically.</p>
                        @endif
                        <div class="mt-6 flex items-center justify-center gap-3">
                            <div class="relative w-10 h-10">
                                <svg viewBox="0 0 36 36" class="w-10 h-10 -rotate-90">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="rgb(0 0 0 / .08)" stroke-width="3" />
                                    <circle id="ring-pg" cx="18" cy="18" r="16" fill="none" stroke="#88c5a4" stroke-width="3" stroke-linecap="round" stroke-dasharray="100.5" stroke-dashoffset="0" class="ring-transition" />
                                </svg>
                                <div id="timer-pg" class="absolute inset-0 grid place-items-center font-mono text-[10px] font-medium text-slate-700">--:--</div>
                            </div>
                            <div class="text-sm text-slate-500">Complete payment before time runs out</div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="flex items-center justify-center gap-2.5 rounded-xl bg-slate-50 ring-1 ring-slate-200 px-4 py-3 text-sm text-slate-600">
                            <svg class="w-4 h-4 animate-spin text-slate-400" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                            <span id="status-text">Waiting for payment…</span>
                        </div>
                    </div>
                @else
                    <div class="checkout-action-heading"><h1>Scan to pay</h1><p>Open your UPI app and scan the QR code.</p><span class="checkout-upi-badge">UPI</span></div>
                    <div class="checkout-payment-options checkout-qr-only">
                        <div id="qr-payment-heading" class="checkout-option-heading"><x-icon name="qr" class="checkout-method-icon w-5 h-5" /><span>Scan QR code</span></div>
                        <div id="panel-qr" role="region" aria-labelledby="qr-payment-heading">
                            <div class="checkout-qr-wrap">
                                <div class="checkout-qr">
                                    <span class="qr-corner corner-tl" aria-hidden="true"></span><span class="qr-corner corner-tr" aria-hidden="true"></span><span class="qr-corner corner-bl" aria-hidden="true"></span><span class="qr-corner corner-br" aria-hidden="true"></span>
                                    <img src="{{ route('pay.qr', $order) }}" width="224" height="224" alt="UPI QR code for ₹{{ $amount }} to {{ $merchant }}">
                                </div>
                            </div>
                            <p class="checkout-scan-caption"><x-icon name="qr" class="w-3.5 h-3.5" /> Scan with any UPI app</p>
                        </div>
                    </div>
                    @if ($order->acceptsCustomerUtr())
                        <details class="checkout-utr-disclosure" data-checkout-utr data-has-utr-error="{{ $errors->has('utr') || $order->review_note ? 'true' : 'false' }}" open>
                            <summary><span>Already paid? <strong>Submit UTR</strong></span><x-icon name="chevron-down" class="w-4 h-4" /></summary>
                            @include('pay._utr-form', ['class' => 'checkout-utr'])
                        </details>
                    @endif
                    <div class="checkout-waiting" role="status" aria-live="polite"><span class="waiting-signal" aria-hidden="true"><i></i><i></i><i></i></span><span id="status-text">{{ $order->acceptsCustomerUtr() ? 'Submit UTR after paying' : 'Waiting for payment confirmation' }}</span></div>
                    <p class="checkout-stay-note">{{ $order->acceptsCustomerUtr() ? 'A UTR submission is reviewed by the merchant before confirmation.' : 'This page updates automatically. Please keep it open after paying.' }}</p>
                @endif
            </section>
        </div>
        @if ($order->isPending() && ! $order->paymentAccount->isHosted())
            <div class="checkout-mobile-paybar">
                <div class="checkout-mobile-total"><strong>₹{{ $amount }}</strong><details class="checkout-mobile-details"><summary>View details <x-icon name="chevron-down" class="w-3 h-3" /></summary><div><h2>Payment details</h2><dl><div><dt>Merchant</dt><dd>{{ $merchant }}</dd></div><div><dt>Order ID</dt><dd>{{ $order->order_no }}</dd></div><div><dt>Amount</dt><dd>₹{{ $amount }}</dd></div>@if ($order->note)<div><dt>Note</dt><dd>{{ $order->note }}</dd></div>@endif</dl></div></details></div>
                <span class="checkout-mobile-qr-note"><x-icon name="qr" class="w-5 h-5" /><span>Scan QR to pay</span></span>
            </div>
        @endif
        <footer class="checkout-footer"><span><x-icon name="lock" class="w-3.5 h-3.5" /> Powered by <strong>{{ config('app.name') }}</strong></span><span>UPI payments</span></footer>
    </main>
</div>
@endsection

@if (in_array($order->status, ['pending', 'review']) || $order->canRecoverLatePayment())
@push('scripts')
<script nonce="{{ $csp_nonce }}">
(() => {
    const initialStatus = @json($order->status);
    const recoveryEndsAt = {{ $order->expires_at?->copy()->addHours((int) config('gateway.late_payment_grace_hours', 24))->getTimestampMs() ?? 0 }};
    const pollDelay = initialStatus === 'expired' ? 30000 : 4000;
    const expiresAt = {{ ($order->expires_at ?? now()->addMinutes(config('gateway.order_expiry_minutes', 15)))->getTimestampMs() }};
    const total = {{ $totalSeconds }};
    const timer = document.getElementById('timer');
    const ring = document.getElementById('ring');
    const statusUrl = @json(route('pay.status', $order));

    const tick = () => {
        if (!timer) return;
        const left = Math.max(0, Math.floor((expiresAt - Date.now()) / 1000));
        const display = String(Math.floor(left / 60)).padStart(2, '0') + ':' + String(left % 60).padStart(2, '0');
        const offset = (100.5 * (1 - Math.min(1, left / total))).toFixed(2);
        const stroke = left < 60 ? '#dc6b45' : '#27865a';
        document.querySelector('.checkout-expiry')?.classList.toggle('is-urgent', left < 60);
        if (left === 0) {
            document.querySelector('.checkout-sheet')?.classList.add('is-expired');
            const startButton = document.querySelector('#pg-start button');
            if (startButton) startButton.disabled = true;
        }
        timer.textContent = display;
        ring.style.strokeDashoffset = offset;
        ring.style.stroke = stroke;
        // Hosted-PG secondary timer widget (different IDs to avoid duplicate-id)
        const timerPg = document.getElementById('timer-pg');
        const ringPg  = document.getElementById('ring-pg');
        if (timerPg) timerPg.textContent = display;
        if (ringPg)  { ringPg.style.strokeDashoffset = offset; ringPg.style.stroke = stroke; }
    };
    tick();
    setInterval(tick, 1000);

    const poll = async () => {
        if (initialStatus === 'expired' && Date.now() > recoveryEndsAt) return;
        try {
            const res = await fetch(statusUrl, { headers: { Accept: 'application/json' } });
            if (res.ok) {
                const data = await res.json();
                if (data.status !== initialStatus) {
                    const text = document.getElementById('status-text');
                    if (text) text.textContent = data.status === 'paid' ? 'Payment received! Redirecting…' : 'Updating…';
                    window.location.href = data.redirect || window.location.href;
                    return;
                }
            }
        } catch (e) {}
        setTimeout(poll, pollDelay);
    };
    setTimeout(poll, pollDelay);
})();
</script>
@endpush
@endif
