<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    @if (!empty($description))
        <meta name="description" content="{{ $description }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "狩野健一のWebサイト",
                "item": "{{ url('/') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "{{ $title }}"
            }
        ]
    }
    </script>
    @vite(['resources/css/a.css'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
</head>

<body>
    {!! $html !!}
    <div
        style="margin-top: 8rem; margin-bottom: -36px; border-top: 1px solid #d1d5db; color: #9ca3af; font-size: 0.7rem; line-height: 1.5;">
        この記事はAI（Claude）によって生成されたものであり、内容の正確性を保証するものではありません。技術的な内容については必ず公式ドキュメントで確認し、重要な判断を行う際は専門家にご相談ください。記事の利用により生じた損害については一切の責任を負いかねます。
    </div>
</body>

</html>
