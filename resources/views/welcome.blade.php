@extends('layouts.base')
@section('title', 'Your business. Your payments. Your bank.')
@push('head')
<meta name="description" content="Accept UPI payments directly into your bank account with GetPaid. Dynamic QR codes, payment links, a merchant dashboard, and signed webhooks.">
@endpush

@section('body')
@php
    $startUrl = auth()->check() ? route('dashboard') : (config('auth.allow_registration', false) ? route('register') : route('login'));
    $startLabel = auth()->check() ? 'Open dashboard' : (config('auth.allow_registration', false) ? 'Get started' : 'Merchant login');
@endphp
<div class="marketing">
    @include('layouts.public-nav')
    <main id="main-content">
        <section class="landing-hero">
            <div class="landing-container hero-grid">
                <div class="hero-copy">
                    <div class="eyebrow"><span class="status-dot"></span> A simpler way to get paid</div>
                    <h1>Your business.<br>Your payments.<br><span>Your bank.</span></h1>
                    <p>Accept UPI payments straight into your bank account. A seamless checkout for your customers. More control for you.</p>
                    <div class="hero-actions">
                        <a href="{{ $startUrl }}" class="btn btn-primary btn-lg">{{ $startLabel }} <x-icon name="arrow-right" class="w-4 h-4" /></a>
                        <a href="#how" class="btn btn-secondary btn-lg">See how it works <x-icon name="chevron-down" class="w-4 h-4" /></a>
                    </div>
                    <div class="hero-note"><x-icon name="check-circle" class="w-4 h-4" /> 0% platform commission <span>·</span> Direct to your account</div>
                </div>
                <figure class="hero-visual">
                    <span class="visual-orbit orbit-one" aria-hidden="true"></span>
                    <span class="visual-orbit orbit-two" aria-hidden="true"></span>
                    <span class="visual-spark spark-one" aria-hidden="true">✦</span>
                    <span class="visual-spark spark-two" aria-hidden="true">+</span>
                    <img src="{{ asset('images/getpaid/product/getpaid-checkout-qr-success-hero-transparent-square_1254x1254.webp') }}" width="1254" height="1254" fetchpriority="high" alt="Demo checkout showing a sample QR code, payment confirmation, and webhook notification. Not for payment.">
                    <figcaption>AN ILLUSTRATION OF A SMOOTHER CHECKOUT</figcaption>
                </figure>
            </div>
            <div class="landing-container value-strip">
                @foreach ([['banknotes', 'Direct to bank', 'Your money, in your account.'], ['qr', 'One QR. Any UPI app.', 'A familiar way for customers to pay.'], ['shield', 'You stay in control', 'Your accounts. Your infrastructure.']] as [$icon, $title, $text])
                    <div><span class="value-icon"><x-icon :name="$icon" class="w-5 h-5" /></span><div><strong>{{ $title }}</strong><p>{{ $text }}</p></div></div>
                @endforeach
            </div>
        </section>

        <section class="payment-apps landing-container" aria-label="Compatible UPI apps">
            <p>THE APPS THEY LOVE. <strong>THE CHECKOUT YOU NEED.</strong></p>
            <div class="payment-app-list">
                @foreach ([['Google Pay', 'gpay'], ['PhonePe', 'phonepe'], ['Paytm', 'paytm'], ['BHIM', 'bhim'], ['CRED', 'cred']] as [$name, $file])
                    <div><img src="{{ asset('images/upi/'.$file.'.png') }}" width="32" height="32" loading="lazy" alt=""><span>{{ $name }}</span></div>
                @endforeach
                <span class="more-apps">& other UPI apps</span>
            </div>
        </section>

        <section id="features" class="landing-section product-section">
            <div class="landing-container">
                <div class="section-heading centered"><div class="eyebrow">LESS FRICTION. MORE FLOW.</div><h2>Everything clicks.<br>From checkout to confirmation.</h2><p>Give your customers a simple way to pay, and your business a clear view of every order.</p></div>
                <div class="product-showcase">
                    <div class="product-window"><div class="window-bar"><span class="window-dots" aria-hidden="true">● ● ●</span><span>YOUR PAYMENT WORKSPACE</span><span class="demo-tag">ILLUSTRATIVE DEMO</span></div><img src="{{ asset('images/getpaid/product/getpaid-dashboard-demo-wide-rectangle_1536x1024.webp') }}" width="1536" height="1024" loading="lazy" alt="Illustrative GetPaid merchant dashboard with sample orders, payment statuses, and demo collection data."></div>
                    <div class="product-caption"><span class="status-dot"></span> Orders, collections, and payment accounts. One clear picture.</div>
                </div>
                <div class="feature-grid">
                    @foreach ([
                        ['dynamic-qr', 'A checkout that just flows', 'Generate a QR code for each order with the amount already filled in. Share a hosted payment link and let customers pay their way.'],
                        ['automatic-verification', 'Less chasing. More clarity.', 'Check payment status through supported providers, with a UTR review workflow for accounts that need manual confirmation.'],
                        ['direct-settlement', 'Straight to your bank', 'Customers pay your own bank-linked UPI account. GetPaid never holds or pools your funds.'],
                        ['signed-webhooks', 'Keep your systems in sync', 'Receive signed payment events, verify their authenticity, and track webhook deliveries from your dashboard.'],
                        ['developer-api', 'Built to fit your stack', 'Create orders and check payment status with a REST API. Test your integration in the sandbox before going live.'],
                        ['multiple-merchants', 'Room for your business', 'Manage multiple UPI accounts, set daily limits, and configure account rotation from one workspace.']
                    ] as [$icon, $title, $text])
                        <article class="feature-item"><img src="{{ asset('images/getpaid/features/getpaid-feature-'.$icon.'_48x48.svg') }}" width="40" height="40" loading="lazy" alt=""><h3>{{ $title }}</h3><p>{{ $text }}</p></article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="how" class="landing-section flow-section">
            <div class="landing-container flow-grid">
                <div class="section-heading"><div class="eyebrow">A SHORTER PATH TO PAID</div><h2>From their phone.<br>Into your account.</h2><p>No extra stop for your money. Just a connected payment experience, from start to finish.</p>
                    <ol class="flow-steps">
                        @foreach ([['Connect your account', 'Add your UPI account and configure its verification method.'], ['Create and share an order', 'Use the dashboard or API to generate a payment link and QR.'], ['Get paid. Keep moving.', 'The customer pays your account. Track confirmation and receive a signed payment event.']] as [$title, $text])
                            <li><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div></li>
                        @endforeach
                    </ol>
                </div>
                <div class="flow-visual"><img src="{{ asset('images/getpaid/product/getpaid-direct-to-bank-payment-flow-wide_1000x660.svg') }}" width="1000" height="660" loading="lazy" alt="Payment flow from a customer’s UPI app directly to the merchant’s bank, with GetPaid handling order verification and notifications."><div class="flow-footnote"><x-icon name="shield" class="w-4 h-4" /> Your funds stay with you. Always.</div></div>
            </div>
        </section>

        <section class="developer-section landing-section">
            <div class="landing-container developer-grid">
                <div class="section-heading"><div class="eyebrow">FOR THE PEOPLE BUILDING WHAT’S NEXT</div><h2>Your next integration.<br>Minus the headache.</h2><p>A straightforward REST API, a separate sandbox, and signed webhooks. All the essentials to make payments part of your product.</p><a href="{{ route('docs') }}" class="btn btn-light mt-7">Explore the API docs <x-icon name="arrow-right" class="w-4 h-4" /></a><div class="developer-tags"><span>REST API</span><span>HMAC-SHA256</span><span>Sandbox mode</span></div></div>
                <div class="code-window"><div class="code-bar"><span><span class="code-method">POST</span> /api/v1/orders</span><span>cURL</span></div>
<pre><code><span class="code-muted"># Your next payment starts here</span>
<span class="code-orange">curl</span> -X POST {{ url('/api/v1/orders') }} \
  -H <span class="code-green">"X-Api-Key: YOUR_API_KEY"</span> \
  -H <span class="code-green">"X-Api-Secret: YOUR_API_SECRET"</span> \
  -H <span class="code-green">"Content-Type: application/json"</span> \
  -d <span class="code-green">'{
    "amount": 499,
    "client_order_id": "INV-1001"
  }'</span></code></pre>
                <div class="code-result"><span class="status-dot"></span> Create an order. Share the link. Get paid.</div></div>
            </div>
        </section>

    {{-- Pricing --}}
    <section id="pricing" class="pricing-section py-20 lg:py-28">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 text-center">
            <div class="text-sm font-semibold text-brand-600">SIMPLE, TRANSPARENT PRICING</div>
            <h2 class="mt-2 text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">Keep 100% of what you earn</h2>
            <p class="mt-4 text-lg text-slate-600">No percentage commission per transaction. Direct-to-bank settlement on every tier.</p>
            <div class="mt-12 grid sm:grid-cols-3 gap-6 items-stretch">

                {{-- Starter --}}
                <div class="card p-8 text-left flex flex-col">
                    <div class="font-semibold text-slate-900 text-lg">Starter</div>
                    <p class="mt-1 text-sm text-slate-500">For individual merchants & indie hackers</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold tracking-tight text-slate-900">Free</span>
                    </div>
                    <div class="mt-1 text-sm text-slate-500">0% transaction fee · forever</div>
                    <ul class="mt-8 space-y-3 text-sm text-slate-700 flex-1">
                        @foreach ([
                            '1 Connected UPI account',
                            'Up to ₹50,000 / day',
                            'Dynamic QR & payment links',
                            'Manual UTR verification fallback',
                            'Standard merchant dashboard',
                        ] as $f)
                            <li class="flex items-center gap-3"><x-icon name="check" class="w-5 h-5 text-emerald-500 shrink-0" /> {{ $f }}</li>
                        @endforeach
                    </ul>
                    @if (config('auth.allow_registration', false))
                    <a href="{{ route('register') }}" class="btn btn-secondary w-full mt-8 py-3">Get started free</a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-secondary w-full mt-8 py-3">Log in</a>
                    @endif
                </div>

                {{-- Pro --}}
                <div class="card p-8 text-left flex flex-col ring-2 ring-brand-600 relative">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-brand-600 px-3 py-0.5 text-xs font-semibold text-white">Most popular</span>
                    <div class="font-semibold text-slate-900 text-lg">Pro</div>
                    <p class="mt-1 text-sm text-slate-500">For fast-growing digital businesses</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold tracking-tight text-slate-900">₹999</span>
                        <span class="text-slate-500">/month</span>
                    </div>
                    <div class="mt-1 text-sm text-slate-500">0% transaction fee · direct settlement</div>
                    <ul class="mt-8 space-y-3 text-sm text-slate-700 flex-1">
                        @foreach ([
                            'Up to 5 UPI accounts with auto-rotation',
                            'Up to ₹5,00,000 / day',
                            'Real-time automated status verification',
                            'Signed webhooks with automated retries',
                            'Comprehensive transaction debugger',
                            'Full REST API access & SDK examples',
                            'Priority support',
                        ] as $f)
                            <li class="flex items-center gap-3"><x-icon name="check" class="w-5 h-5 text-brand-600 shrink-0" /> {{ $f }}</li>
                        @endforeach
                    </ul>
                    @if (config('auth.allow_registration', false))
                    <a href="{{ route('register') }}" class="btn btn-primary w-full mt-8 py-3">Start free trial</a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-full mt-8 py-3">Get Started</a>
                    @endif
                </div>

                {{-- Business --}}
                <div class="card p-8 text-left flex flex-col">
                    <div class="font-semibold text-slate-900 text-lg">Enterprise</div>
                    <p class="mt-1 text-sm text-slate-500">For high-scale platforms & agencies</p>
                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold tracking-tight text-slate-900">₹2,999</span>
                        <span class="text-slate-500">/month</span>
                    </div>
                    <div class="mt-1 text-sm text-slate-500">0% transaction fee · unlimited scale</div>
                    <ul class="mt-8 space-y-3 text-sm text-slate-700 flex-1">
                        @foreach ([
                            'Unlimited UPI accounts & merchants',
                            'Unlimited daily payment volume',
                            'Instant multi-channel verification',
                            'White-labeled branded checkout pages',
                            'Automated outbox archive retention',
                            'Advanced export & reconciliation engine',
                            'Dedicated deployment manager',
                        ] as $f)
                            <li class="flex items-center gap-3"><x-icon name="check" class="w-5 h-5 text-emerald-500 shrink-0" /> {{ $f }}</li>
                        @endforeach
                    </ul>
                    @if (config('auth.allow_registration', false))
                    <a href="{{ route('register') }}" class="btn btn-secondary w-full mt-8 py-3">Contact team</a>
                    @else
                    <a href="{{ route('docs') }}" class="btn btn-secondary w-full mt-8 py-3">View API Docs</a>
                    @endif
                </div>

            </div>
            <p class="mt-8 text-sm text-slate-500">All plans feature direct-to-bank settlement. Zero intermediary holds. Cancel or upgrade anytime.</p>
        </div>
    </section>


        <section class="landing-section faq-section">
            <div class="landing-container faq-grid"><div class="section-heading"><div class="eyebrow">A LITTLE MORE CLARITY</div><h2>Good questions.<br>Straight answers.</h2><p>Getting started? Here’s what to know.</p><a href="{{ route('docs') }}" class="text-brand-700 inline-flex items-center gap-2 font-semibold mt-6 text-sm">Read the documentation <x-icon name="arrow-right" class="w-4 h-4" /></a></div>
                <div class="faq-list">
                    @foreach ([
                        ['Does GetPaid hold my money?', 'No. Your customer pays directly into your bank-linked UPI account. GetPaid provides the checkout, order tracking, payment verification workflow, and webhook notifications.'],
                        ['How are payments verified?', 'Supported payment providers can confirm payments automatically. For standard UPI accounts, customers can submit a UTR reference for you to review against your bank or UPI app. A submitted reference alone does not confirm a payment.'],
                        ['Which UPI apps can customers use?', 'Customers can scan the payment QR using a compatible UPI app. On supported mobile devices, checkout also offers direct links to apps including Google Pay, PhonePe, Paytm, BHIM, and CRED.'],
                        ['Can I test before accepting real payments?', 'Yes. Use the separate sandbox credentials and simulated checkout to test orders and webhook handling without moving real money.'],
                        ['Can I host GetPaid myself?', 'Yes. GetPaid is a self-hosted application with a guided installer. See the documentation for deployment requirements and setup.']
                    ] as [$question, $answer])
                        <details class="faq-item"><summary>{{ $question }}<span aria-hidden="true">+</span></summary><p>{{ $answer }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="landing-container"><div class="closing-cta"><div><div class="eyebrow">LESS BETWEEN YOU AND YOUR MONEY</div><h2>Good business deserves<br>a better way to get paid.</h2></div><div><a href="{{ $startUrl }}" class="btn btn-primary btn-lg">{{ $startLabel }} <x-icon name="arrow-right" class="w-4 h-4" /></a><p>Direct payments. A simpler everyday.</p></div></div></section>
    </main>
    <footer class="landing-footer landing-container"><div class="footer-top"><div><a href="{{ route('home') }}" aria-label="GetPaid home"><x-logo /></a><p>Made for the way India pays.</p></div><nav aria-label="Footer navigation"><a href="#features">Features</a><a href="#how">How it works</a><a href="#pricing">Pricing</a><a href="{{ route('docs') }}">Documentation</a><a href="{{ route('login') }}">Merchant login</a></nav></div><div class="footer-bottom"><span>© {{ date('Y') }} {{ config('app.name', 'GetPaid') }}. All rights reserved.</span><span>Built around UPI. Built around you.</span></div></footer>
</div>
@endsection
