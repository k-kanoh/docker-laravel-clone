<x-app-layout>
  <x-slot name="title">狩野健一のWebサイト</x-slot>
  <x-slot name="header">
    <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
      狩野健一のWebサイト
    </h2>
  </x-slot>
  <div class="py-8">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
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
    </div>
  </div>
</x-app-layout>
