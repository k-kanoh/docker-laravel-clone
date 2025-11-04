<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>狩野健一のWebサイト</title>

    <meta name="description" content="狩野健一のWebサイト。個人開発のWebアプリケーション、東方Project関連ツール、プログラミングやサーバ構築の備忘録など。">
    <link rel="canonical" href="{{ url('/') }}">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "狩野健一のWebサイト",
        "url": "{{ url('/') }}",
        "description": "狩野健一のWebサイト。個人開発のWebアプリケーション、東方Project関連ツール、プログラミングやサーバ構築の備忘録など。"
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "itemListElement": [
            @foreach ($articles as $i => $article)
            {
                "@type": "ListItem",
                "position": {{ $i + 1 }},
                "url": "{{ route('md.show', $article['id']) }}",
                "name": "{{ $article['title'] }}"
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-dvh bg-gray-100 dark:bg-gray-900" x-data="{ loginDrawer: {{ $errors->any() ? 'true' : 'false' }} }">
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="relative max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center sm:justify-start">
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        狩野健一のWebサイト
                    </h2>
                </div>
                <div class="absolute top-1/2 -translate-y-1/2 right-2 sm:right-6 lg:right-8">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-2 py-2 text-sm bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                                <span class="hidden sm:inline">ログアウト</span>
                            </button>
                        </form>
                    @else
                        <button @click="loginDrawer = true"
                            class="flex items-center gap-2 px-2 py-2 text-sm bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                            <span class="hidden sm:inline">ログイン</span>
                        </button>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Drawer Overlay -->
        <div x-show="loginDrawer" x-transition.opacity @click="loginDrawer = false"
            class="fixed inset-0 z-50 bg-black/50" style="display: none;"></div>

        <!-- Drawer Content -->
        <div x-show="loginDrawer" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full" @click.away="loginDrawer = false"
            class="fixed inset-x-0 bottom-0 z-50 mt-24 flex h-auto flex-col rounded-t-[10px] border bg-white dark:bg-gray-800 shadow-lg"
            style="display: none;">

            <!-- Handle -->
            <div class="mx-auto mt-4 h-2 w-[100px] rounded-full bg-gray-300 dark:bg-gray-600"></div>

            <!-- Login Form -->
            <div class="w-96 max-w-full mx-auto p-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            メールアドレス
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autofocus x-init="$watch('loginDrawer', value => value && setTimeout(() => $el.focus(), 100))"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:text-gray-200">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            パスワード
                        </label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:text-gray-200">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 dark:border-gray-600 text-yellow-600 focus:ring-yellow-500 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">ログイン状態を保持する</span>
                        </label>
                        <button type="submit"
                            class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-colors duration-200">
                            ログイン
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <main>
            <div class="py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                        <div class="p-6">
                            <ul class="space-y-4">
                                <li
                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <a href="/gen"
                                        class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                        <div class="font-semibold text-lg text-yellow-600 dark:text-yellow-400">
                                            幻想郷Radioリアルタイム
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Reactベースのアプリケーション</p>
                                    </a>
                                </li>
                                <li
                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <a href="/thssren.html"
                                        class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                        <div class="font-semibold text-lg text-yellow-600 dark:text-yellow-400">
                                            thssren(東方スクショリネーマー)
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                            歯抜けになった東方スクショファイルを000から振りなおします。
                                        </p>
                                    </a>
                                </li>
                                <li
                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <a href="/barcode"
                                        class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg pointer-events-none">
                                        <div class="font-semibold text-lg text-gray-400">Barcode Reader</div>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">開発中</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">技術メモ</h3>
                            <div class="text-sm pl-4">
                                @foreach ($articles as $article)
                                    <div
                                        class="group flex items-baseline gap-4 py-1.5 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <span class="text-gray-400 dark:text-gray-500 text-xs w-16 flex-shrink-0">
                                            {{ date('Y/m/d', $article['updated_at']) }}
                                        </span>
                                        <a href="{{ route('md.show', $article['id']) }}"
                                            class="text-gray-700 dark:text-gray-300 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                                            @if ($article['group'])
                                                <span
                                                    class="article-group-label color-{{ $article['color'] }}">{{ $article['group'] }}</span>
                                            @endif
                                            {{ $article['title'] }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
