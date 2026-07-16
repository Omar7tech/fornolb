<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>{{ url('/') }}</loc>
        @if ($lastModified)
            <lastmod>{{ $lastModified->toAtomString() }}</lastmod>
        @endif
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        <image:image>
            <image:loc>{{ asset(config('seo.og_image')) }}</image:loc>
            <image:title>{{ config('seo.name') }}</image:title>
        </image:image>
    </url>
</urlset>
