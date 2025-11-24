<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>代理バーコードリーダー</title>
    <meta name="description" content="PC等カメラを持たない端末でスマホを利用して一次元バーコード/QRコードを読み取ります。" />
    <link href="{{ url("/barcode") }}" rel="canonical" />
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "代理バーコードリーダー",
        "description": "PC等カメラを持たない端末でスマホを利用して一次元バーコード/QRコードを読み取ります。",
        "applicationCategory": "UtilitiesApplication",
        "operatingSystem": "Web Browser",
        "offers": {
          "@type": "Offer",
          "price": "0",
          "priceCurrency": "JPY"
        }
      }
    </script>
    @vite(["resources/css/app.css"])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
      [x-cloak] {
        display: none;
      }
    </style>
  </head>

  <body>
    <div class="mx-auto min-h-screen max-w-4xl p-4" x-data="displayApp()">
      <h1 class="mb-2 text-3xl font-bold">代理バーコードリーダー</h1>
      <p class="text-gray-600">PC等カメラを持たない端末でスマホを利用して一次元バーコード/QRコードを読み取ります。</p>

      <template x-if="error">
        <p class="mt-4 text-center text-sm font-bold text-red-600" x-text="error"></p>
      </template>

      <template x-if="!error">
        <div class="m-auto my-5 flex w-1/2 flex-col items-center rounded-lg bg-gray-50 p-6">
          <div class="bg-white p-4" id="qrcode"></div>
          <p class="mt-4 text-center text-sm text-gray-600">スマホでこのQRコードを読み取ってください</p>
        </div>
      </template>

      <div x-show="data.length" x-cloak>
        <div class="mb-2 flex flex-wrap items-end justify-between">
          <h2 class="text-xl font-semibold">
            スキャン結果 (
            <span x-text="data.length"></span>
            件)
          </h2>
          <div class="flex gap-2">
            <button class="cursor-pointer rounded border-none bg-green-600 px-4 py-2 font-bold text-white hover:bg-green-700" @click="copyToClipboard">
              クリップボードにコピー
            </button>
            <button class="cursor-pointer rounded border-none bg-red-600 px-4 py-2 font-bold text-white hover:bg-red-700" @click="clearData">クリア</button>
          </div>
        </div>
        <div class="max-h-[370px] overflow-y-auto rounded border border-gray-200 bg-gray-50">
          <template x-for="(x, i) in data" :key="i">
            <div class="break-all border-b border-gray-200 px-3 py-2 font-mono text-sm last:border-b-0" x-text="x.x"></div>
          </template>
        </div>
      </div>
    </div>

    <script>
      function displayApp() {
        return {
          id: '',
          data: [],
          error: '',
          pollInterval: null,

          async init() {
            await this.createSession();
            if (this.id) {
              this.generateQRCode();
              this.startPolling();
            }
          },

          async createSession() {
            try {
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              const response = await fetch('/api/barcode/create', {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                },
              });

              if (!response.ok) {
                this.error = (await response.json()).message;
                return;
              }

              this.id = (await response.json()).id;
            } catch (err) {
              this.error = 'Fetchに失敗しました';
              console.error(err);
            }
          },

          generateQRCode() {
            new QRCode(document.getElementById('qrcode'), {
              text: `${window.location.origin}/barcode/scanner?id=${this.id}`,
              width: 200,
              height: 200,
            });
          },

          startPolling() {
            this.pollInterval = setInterval(async () => {
              try {
                const response = await fetch(`/api/barcode/poll/${this.id}`);

                if (!response.ok) return;

                this.data = (await response.json()).data ?? [];
              } catch (err) {
                console.error(err);
              }
            }, 3000);
          },

          async copyToClipboard() {
            const text = this.data.map((x) => `${x.x}\n`).join('');
            try {
              await navigator.clipboard.writeText(text);
              alert('クリップボードにコピーしました！');
            } catch (err) {
              console.error(err);
              alert('コピーに失敗しました');
            }
          },

          async clearData() {
            try {
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              const response = await fetch(`/api/barcode/clear/${this.id}`, {
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                },
              });

              if (!response.ok) {
                this.error = (await response.json()).message;
                return;
              }

              this.data = [];
            } catch (err) {
              this.error = 'Fetchに失敗しました';
              console.error(err);
            }
          },
        };
      }
    </script>
  </body>
</html>
