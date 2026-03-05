@php
    $siteSettings = $siteSettings ?? [];
    $siteName = $siteSettings['site_name'] ?? 'RADYOYOL';
    $metaTitle = $siteSettings['seo_meta_title'] ?? $siteName;
    $metaDesc = $siteSettings['seo_meta_description'] ?? '';
    $metaKeywords = $siteSettings['seo_meta_keywords'] ?? '';
    $metaAuthor = $siteSettings['seo_meta_author'] ?? '';
    $metaRobots = $siteSettings['seo_meta_robots'] ?? 'index,follow';
    $canonicalUrl = $siteSettings['seo_canonical_url'] ?? url('/');
    if (empty(trim($canonicalUrl))) $canonicalUrl = url('/');

    $ogTitle = $siteSettings['seo_og_title'] ?? $metaTitle;
    $ogDesc = $siteSettings['seo_og_description'] ?? $metaDesc;
    $ogImage = isset($siteSettings['seo_og_image_path']) && $siteSettings['seo_og_image_path']
        ? asset('storage/' . $siteSettings['seo_og_image_path']) : '';
    $ogType = $siteSettings['seo_og_type'] ?? 'website';
    $ogLocale = $siteSettings['seo_og_locale'] ?? 'tr_TR';

    $twitterCard = $siteSettings['seo_twitter_card'] ?? 'summary_large_image';
    $twitterSite = $siteSettings['seo_twitter_site'] ?? '';
    $twitterCreator = $siteSettings['seo_twitter_creator'] ?? '';

    $googleVerification = $siteSettings['seo_google_verification'] ?? '';
    $bingVerification = $siteSettings['seo_bing_verification'] ?? '';
    $yandexVerification = $siteSettings['seo_yandex_verification'] ?? '';

    $schemaOrgName = $siteSettings['seo_schema_org_name'] ?? $siteName;
    $schemaOrgUrl = $siteSettings['seo_schema_org_url'] ?? url('/');
    $schemaOrgLogo = $siteSettings['seo_schema_org_logo'] ?? '';
    $schemaDesc = $siteSettings['seo_schema_description'] ?? $metaDesc;
    $schemaRadioStation = (bool) ($siteSettings['seo_schema_radio_station'] ?? true);

    $metaReferrer = $siteSettings['seo_meta_referrer'] ?? '';
    $geoRegion = $siteSettings['seo_geo_region'] ?? '';
    $sitemapUrl = $siteSettings['seo_sitemap_url'] ?? '';
@endphp
{{-- Temel Meta --}}
@if($metaDesc)<meta name="description" content="{{ $metaDesc }}">@endif
@if($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
@if($metaAuthor)<meta name="author" content="{{ $metaAuthor }}">@endif
<meta name="robots" content="{{ $metaRobots }}">
@if($metaReferrer)<meta name="referrer" content="{{ $metaReferrer }}">@endif
@if($geoRegion)<meta name="geo.region" content="{{ $geoRegion }}">@endif

<link rel="canonical" href="{{ $canonicalUrl }}">
@if($sitemapUrl)<link rel="sitemap" type="application/xml" href="{{ $sitemapUrl }}">@endif

{{-- Open Graph --}}
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $ogTitle }}">
@if($ogDesc)<meta property="og:description" content="{{ $ogDesc }}">@endif
@if($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ $ogLocale }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
@if($ogDesc)<meta name="twitter:description" content="{{ $ogDesc }}">@endif
@if($ogImage)<meta name="twitter:image" content="{{ $ogImage }}">@endif
@if($twitterSite)<meta name="twitter:site" content="{{ $twitterSite }}">@endif
@if($twitterCreator)<meta name="twitter:creator" content="{{ $twitterCreator }}">@endif

{{-- Arama Motoru Doğrulama --}}
@if($googleVerification)<meta name="google-site-verification" content="{{ $googleVerification }}">@endif
@if($bingVerification)<meta name="msvalidate.01" content="{{ $bingVerification }}">@endif
@if($yandexVerification)<meta name="yandex-verification" content="{{ $yandexVerification }}">@endif

{{-- Schema.org JSON-LD --}}
@php
    $schemaName = $schemaOrgName ?: $siteName;
    $schemaUrl = $schemaOrgUrl ?: url('/');
    $org = ['@type' => 'Organization', 'name' => $schemaName, 'url' => $schemaUrl];
    if ($schemaOrgLogo) $org['logo'] = $schemaOrgLogo;
    if ($schemaDesc) $org['description'] = $schemaDesc;
    $website = ['@type' => 'WebSite', 'name' => $schemaName, 'url' => $schemaUrl];
    if ($schemaDesc) $website['description'] = $schemaDesc;
    $schemaGraph = [$org];
    if ($schemaRadioStation) {
        $radio = ['@type' => 'RadioStation', 'name' => $schemaName, 'url' => $schemaUrl];
        if ($schemaDesc) $radio['description'] = $schemaDesc;
        $schemaGraph[] = $radio;
    }
    $schemaGraph[] = $website;
@endphp
<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
