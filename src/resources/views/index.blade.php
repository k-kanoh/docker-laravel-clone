<x-app-layout>
    <x-slot name="title">狩野健一のWebサイト</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            狩野健一のWebサイト
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                            <a href="/barcode"
                                class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg pointer-events-none">
                                <div class="font-semibold text-lg text-gray-400">Barcode Reader</div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">開発中</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
