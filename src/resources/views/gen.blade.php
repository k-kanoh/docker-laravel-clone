<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>砕月</title>

    <link rel="preload" as="style" href="/genbuild/main.css" />
    <link rel="modulepreload" href="/genbuild/main.js" />
    <link rel="stylesheet" href="/genbuild/main.css" />
    <script type="module" src="/genbuild/main.js"></script>
</head>

<body class="font-sans antialiased">
    <div id="root"></div>
</body>

</html>
