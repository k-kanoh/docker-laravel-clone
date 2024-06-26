<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cheap React</title>
    @viteReactRefresh
    @vite(['frontend/main.css', 'frontend/main.tsx'])
</head>

<body>
    <div id="root" />
</body>

</html>
