<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
@isset($seo)
    <meta name="description" content="{{ $seo['description'] }}" />
    <meta name="keywords" content="{{ $seo['keywords'] }}" />
    <meta property="og:image" content="{{ $seo['image'] }}" />
@else
<meta name="description" content="@lang('site.meta_description')" />
<meta name="keywords" content="@lang('site.meta_keywords')" />
@endisset

<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="{{ app()->getLocale() }}" />

<link rel="author" type="text/plain" href="humans.txt" />
<link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>

@foreach(config('language.allowed') as $langCode)
@if(config('app.locale') === $langCode)
@continue
@endif
<link rel="alternate" hreflang="{{ $langCode }}" href="{{ url()->current()}}?lang={{ $langCode }}" />
@endforeach
