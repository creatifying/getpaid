<header class="site-header" id="site-header">
    <div class="site-header-inner">
        <a href="{{ route('home') }}" aria-label="{{ config('app.name', 'GetPaid') }} home"><x-logo /></a>
        <nav class="public-links" aria-label="Main navigation">
            <a href="{{ route('home') }}#features">Features</a>
            <a href="{{ route('home') }}#how">How it works</a>
            <a href="{{ route('home') }}#pricing">Pricing</a>
            <a href="{{ route('docs') }}">Developers <span aria-hidden="true">↗</span></a>
        </nav>
        <div class="public-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard <x-icon name="arrow-right" class="w-4 h-4" /></a>
            @else
                @if (config('auth.allow_registration', false))
                    <a href="{{ route('login') }}" class="btn btn-ghost public-login">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get started <x-icon name="arrow-right" class="w-4 h-4" /></a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Merchant login <x-icon name="arrow-right" class="w-4 h-4" /></a>
                @endif
            @endauth
            <button type="button" class="btn btn-ghost public-menu-toggle" data-public-menu-toggle aria-controls="public-mobile-menu" aria-expanded="false" aria-label="Toggle navigation"><x-icon name="menu" class="w-5 h-5" /></button>
        </div>
    </div>
    <nav id="public-mobile-menu" class="mobile-public-nav" aria-label="Mobile navigation" hidden>
        <a href="{{ route('home') }}#features">Features</a>
        <a href="{{ route('home') }}#how">How it works</a>
        <a href="{{ route('home') }}#pricing">Pricing</a>
        <a href="{{ route('docs') }}">Developer documentation</a>
        @guest <a href="{{ route('login') }}">Merchant login</a> @endguest
    </nav>
</header>
