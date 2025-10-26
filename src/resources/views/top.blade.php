<x-app-layout>
  <x-slot name="title">狩野健一のWebサイト</x-slot>
  @push('head')
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
  @endpush
  <x-slot name="header">
    <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
      狩野健一のWebサイト
    </h2>
  </x-slot>
  <div class="py-8">
    <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
      <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
        <div class="p-6">
          <ul class="space-y-4">
            <li class="rounded-lg bg-white shadow-md transition-shadow duration-300 hover:shadow-lg dark:bg-gray-800">
              <a class="block rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="/gen">
                <div class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">幻想郷Radioリアルタイム
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
                  {{ $article['title'] }}
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
