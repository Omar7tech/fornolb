@php
    // Without SSR the crawler receives an empty <div>, so everything below —
    // the meta tags, the structured data, and the <noscript> menu — is the only
    // description of this business it ever sees. `$page` carries the props the
    // controller already resolved, so none of this costs an extra query.
    $categories = $page['props']['categories'] ?? [];
    $schema = app(\App\Support\RestaurantSchema::class)->build($categories);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Apply the saved theme before paint to avoid a flash of the wrong appearance. --}}
    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 'system';
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (theme === 'dark' || (theme === 'system' && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <meta name="description" content="{{ config('seo.description') }}">
    <meta name="author" content="{{ config('seo.name') }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Sharing previews: Facebook, WhatsApp, LinkedIn. --}}
    <meta property="og:site_name" content="{{ config('seo.name') }}">
    <meta property="og:type" content="restaurant.restaurant">
    <meta property="og:title" content="{{ config('seo.title') }}">
    <meta property="og:description" content="{{ config('seo.description') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:image" content="{{ asset(config('seo.og_image')) }}">
    <meta property="og:image:secure_url" content="{{ asset(config('seo.og_image')) }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="{{ config('seo.og_image_width') }}">
    <meta property="og:image:height" content="{{ config('seo.og_image_height') }}">
    <meta property="og:image:alt" content="{{ config('seo.og_image_alt') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('seo.title') }}">
    <meta name="twitter:description" content="{{ config('seo.description') }}">
    <meta name="twitter:image" content="{{ asset(config('seo.og_image')) }}">
    <meta name="twitter:image:alt" content="{{ config('seo.og_image_alt') }}">

    {{-- Local search signals, mirroring the structured data below. --}}
    <meta name="geo.placename" content="{{ config('seo.address.locality') }}">
    <meta name="geo.region" content="LB-JL">
    @if (config('seo.geo.latitude') && config('seo.geo.longitude'))
        <meta name="geo.position" content="{{ config('seo.geo.latitude') }};{{ config('seo.geo.longitude') }}">
        <meta name="ICBM" content="{{ config('seo.geo.latitude') }}, {{ config('seo.geo.longitude') }}">
    @endif

    <meta name="theme-color" content="#1a6b6b" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0e1f1c" media="(prefers-color-scheme: dark)">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Forno" />
    <link rel="manifest" href="/site.webmanifest" />
    @fonts

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
    <x-inertia::head>
        <title>{{ config('seo.title') }}</title>
    </x-inertia::head>

    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>

<body class="font-sans antialiased">
    <x-inertia::app />

    {{-- The menu in plain HTML, for anything that reads the page without running
         JavaScript. React replaces nothing here: the browser drops <noscript>
         content entirely once scripting is on, so this is invisible to visitors. --}}
    <noscript>
        <h1>{{ config('seo.name') }} — {{ config('seo.address.locality') }}, Lebanon</h1>
        <p>{{ config('seo.description') }}</p>

        @foreach ($categories as $category)
            <h2>{{ $category['title'] }}</h2>
            <ul>
                @foreach ($category['products'] as $product)
                    <li>
                        <strong>{{ $product['title'] }}</strong>
                        @if ($product['description'])
                            — {{ $product['description'] }}
                        @endif
                        ${{ number_format((float) ($product['discount_price'] ?? $product['price']), 2) }}
                    </li>
                @endforeach
            </ul>
        @endforeach
    </noscript>
</body>

</html>
