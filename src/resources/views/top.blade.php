<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>狩野健一のWebサイト</title>
  <meta name="description" content="狩野健一のWebサイト。個人開発のWebアプリケーション、東方Project関連ツール、プログラミングやサーバ構築の備忘録など。">
  <link href="{{ url('/') }}" rel="canonical">
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "狩野健一のWebサイト",
      "url": "{{ url("/") }}",
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
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
  <div class="min-h-dvh bg-gray-100 dark:bg-gray-900" x-data="{ loginDrawer: {{ $errors->any() ? 'true' : 'false' }} }">
    <header class="bg-white shadow dark:bg-gray-800">
      <div class="relative mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex justify-center sm:justify-start">
          <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            狩野健一のWebサイト
          </h2>
        </div>
        <div class="absolute right-2 top-1/2 -translate-y-1/2 sm:right-6 lg:right-8">
          @auth
            <form class="inline" method="POST" action="{{ route('logout') }}">
              @csrf
              <button
                class="flex items-center gap-2 rounded-lg bg-yellow-600 px-2 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-yellow-700"
                type="submit">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                  <polyline points="16 17 21 12 16 7" />
                  <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span class="hidden sm:inline">ログアウト</span>
              </button>
            </form>
          @else
            <button
              class="flex items-center gap-2 rounded-lg bg-yellow-600 px-2 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-yellow-700"
              @click="loginDrawer = true">
              <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
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
    <div class="fixed inset-0 z-50 bg-black/50" style="display: none;" x-show="loginDrawer" x-transition.opacity @click="loginDrawer = false"></div>

    <!-- Drawer Content -->
    <div class="fixed inset-x-0 bottom-0 z-50 mt-24 flex h-auto flex-col rounded-t-[10px] border bg-white shadow-lg dark:bg-gray-800" style="display: none;"
      x-show="loginDrawer" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full"
      x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0"
      x-transition:leave-end="translate-y-full" @click.away="loginDrawer = false">

      <!-- Handle -->
      <div class="mx-auto mt-4 h-2 w-[100px] rounded-full bg-gray-300 dark:bg-gray-600"></div>

      <!-- Login Form -->
      <div class="mx-auto w-96 max-w-full p-6">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-4">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="email">
              メールアドレス
            </label>
            <input
              class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
              id="email" name="email" type="email" value="{{ old('email') }}" required autofocus x-init="$watch('loginDrawer', value => value && setTimeout(() => $el.focus(), 100))">
            @error('email')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="password">
              パスワード
            </label>
            <input
              class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
              id="password" name="password" type="password" required>
            @error('password')
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 dark:border-gray-600 dark:bg-gray-700" name="remember"
                type="checkbox">
              <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">ログイン状態を保持する</span>
            </label>
            <button class="rounded-lg bg-yellow-600 px-6 py-2 font-semibold text-white transition-colors duration-200 hover:bg-yellow-700" type="submit">
              ログイン
            </button>
          </div>
        </form>
      </div>
    </div>
    <main>
      <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
          <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
            <div class="p-6">
              <ul class="space-y-4">
                <li class="rounded-lg bg-white shadow-md transition-shadow duration-300 hover:shadow-lg dark:bg-gray-800">
                  <a class="block rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="/gen">
                    <div class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">
                      幻想郷Radioリアルタイム
                    </div>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Reactベースのアプリケーション</p>
                  </a>
                </li>
                <li class="rounded-lg bg-white shadow-md transition-shadow duration-300 hover:shadow-lg dark:bg-gray-800">
                  <a class="block rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="/thssren.html">
                    <div class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">
                      thssren(東方スクショリネーマー)
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                      歯抜けになった東方スクショファイルを000から振りなおします。
                    </p>
                  </a>
                </li>
                <li class="rounded-lg bg-white shadow-md transition-shadow duration-300 hover:shadow-lg dark:bg-gray-800">
                  <a class="pointer-events-none block rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="/barcode">
                    <div class="text-lg font-semibold text-gray-400">Barcode Reader</div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">開発中</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
            <div class="p-6">
              <h3 class="mb-2 text-lg font-semibold text-gray-800 dark:text-gray-200">技術メモ</h3>
              <div class="pl-4 text-sm">
                @foreach ($articles as $article)
                  <div
                    class="group flex items-baseline gap-4 border-b border-gray-100 py-1.5 last:border-0 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700/50">
                    <span class="w-16 flex-shrink-0 text-xs text-gray-400 dark:text-gray-500">
                      {{ date('Y/m/d', $article['updated_at']) }}
                    </span>
                    <a class="text-gray-700 transition-colors group-hover:text-yellow-600 dark:text-gray-300 dark:group-hover:text-yellow-400"
                      href="{{ route('md.show', $article['id']) }}">
                      @if ($article['group'])
                        <span class="article-group-label color-{{ $article['color'] }}">{{ $article['group'] }}</span>
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
