<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>代理バーコードリーダー</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    @vite(["resources/css/app.css"])
  </head>

  <body>
    <div class="min-h-screen p-4" x-data="scannerApp()">
      <div class="mx-auto max-w-2xl">
        <template x-if="!id">
          <p class="mt-4 text-center text-sm font-bold text-red-600">セッションが指定されていません</p>
        </template>

        <template x-if="id">
          <div>
            <div class="rounded-lg bg-white p-6 shadow-lg">
              <div class="relative w-full">
                <div id="qr-reader"></div>
                <div
                  class="absolute bottom-[5%] left-1/2 z-50 -translate-x-1/2 text-nowrap rounded border border-green-400 bg-green-200 px-4 py-1 text-xs text-green-600"
                  x-text="success"
                  x-show="success"
                ></div>
                <template x-if="scanning && error">
                  <div
                    class="absolute bottom-[5%] left-1/2 z-50 -translate-x-1/2 text-nowrap rounded border border-red-400 bg-red-200 px-4 py-1 text-xs text-red-600"
                    x-text="error"
                  ></div>
                </template>
                <template x-if="!scanning && error">
                  <p class="mt-4 text-center text-sm font-bold text-red-600" x-html="error"></p>
                </template>
              </div>

              <template x-if="!scanning">
                <div class="py-8 text-center">
                  <p class="mb-4 text-gray-500">カメラを起動してバーコードをスキャンします</p>
                  <button
                    class="rounded border-none px-4 py-2 font-bold"
                    @click="startScanning"
                    :disabled="!!error"
                    :class="{ 'bg-green-600 text-white': !error, 'bg-gray-300 text-gray-500': error }"
                  >
                    カメラを起動
                  </button>
                </div>
              </template>

              <template x-if="scanning">
                <div class="mt-4 text-center">
                  <button class="rounded border-none bg-red-600 px-4 py-2 font-bold text-white" @click="stopScanning">カメラを停止</button>
                </div>
              </template>
            </div>

            <div class="mt-8 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700">
              <p class="mb-2 font-bold text-blue-800">💡ヒント</p>
              <p>一次元バーコードの読み取りはシビアです。水平に合わせてしっかり静止してください。</p>
            </div>
          </div>
        </template>
      </div>
    </div>

    <script>
      function scannerApp() {
        return {
          id: '',
          scanning: false,
          error: '',
          success: '',
          html5QrCode: null,
          lastScannedText: '',
          lastScannedTime: 0,
          isProcessing: false,

          init() {
            const params = new URLSearchParams(window.location.search);
            this.id = params.get('id');
          },

          async startScanning() {
            try {
              this.html5QrCode = new Html5Qrcode('qr-reader');

              await this.html5QrCode.start(
                {
                  facingMode: 'environment',
                },
                {
                  fps: 10,
                  qrbox: {
                    width: 250,
                    height: 250,
                  },
                },
                async (text) => {
                  if (this.isProcessing) return;

                  this.error = this.success = '';

                  const now = Date.now();
                  if (text === this.lastScannedText && now - this.lastScannedTime < 3000) {
                    this.success = '直前と同じバーコードをスキャンしています';
                    return;
                  }

                  this.isProcessing = true;
                  this.lastScannedText = text;
                  this.lastScannedTime = now;

                  await this.sendScannedData(text);

                  setTimeout(() => {
                    this.error = this.success = '';
                    this.isProcessing = false;
                  }, 1000);

                  if (this.error) return;

                  this.success = 'スキャン成功';

                  this.playBeep();
                }
              );

              this.scanning = true;
            } catch (err) {
              switch (err) {
                case 'Error getting userMedia, error = NotAllowedError: Permission denied':
                  this.error = 'カメラの使用が許可されていません<br />ブラウザの設定でカメラの権限を許可してください';
                  break;
                case 'Camera streaming not supported by the browser.':
                  this.error = 'HTTPSでアクセスしてください';
                  break;
                default:
                  this.error = 'カメラの起動に失敗しました';
                  break;
              }

              console.error(err);
            }
          },

          async stopScanning() {
            if (this.html5QrCode) {
              try {
                await this.html5QrCode.stop();
                this.html5QrCode = null;
                this.scanning = false;
              } catch (err) {
                this.error = 'カメラの停止に失敗しました';
                console.error(err);
              }
            }
          },

          formatTimestamp(timestamp) {
            return new Date(timestamp).toLocaleString('ja-JP');
          },

          async sendScannedData(text) {
            try {
              const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
              const response = await fetch(`/api/barcode/scan/${this.id}`, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                  text,
                }),
              });

              if (!response.ok) {
                this.error = (await response.json()).message;
                return;
              }
            } catch (err) {
              this.error = 'データの送信に失敗しました';
              console.error(err);
            }
          },

          playBeep() {
            const audioContext = new AudioContext();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 800;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
          },
        };
      }
    </script>
  </body>
</html>
