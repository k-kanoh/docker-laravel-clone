<x-app-layout>
    <x-slot name="title">狩野健一のWebサイト</x-slot>

    @push('head')
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
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            狩野健一のWebサイト
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                <div class="p-6">
                    <ul class="space-y-4">
                        <li
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <a href="/gen" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                <div class="font-semibold text-lg text-yellow-600 dark:text-yellow-400">幻想郷Radioリアルタイム
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
