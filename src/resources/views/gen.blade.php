@php
    $manifest = json_decode(file_get_contents(public_path('genbuild/.vite/manifest.json')), true);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>砕月</title>

    @foreach ($manifest as $entry)
        @if (isset($entry['css']))
            @foreach ($entry['css'] as $css)
                <link rel="stylesheet" href="/genbuild/{{ $css }}" />
            @endforeach
        @endif

        <link rel="modulepreload" href="/genbuild/{{ $entry['file'] }}" />
        @if (isset($entry['isEntry']) && $entry['isEntry'])
            <script type="module" src="/genbuild/{{ $entry['file'] }}"></script>
        @endif
    @endforeach

</head>

<body class="font-sans antialiased">
    <div id="root"></div>
</body>

</html>
