<div class="container mx-auto px-4">
    <div class="max-w-xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-lg border text-center space-y-6"
         @if($signStatus === 'pending') wire:poll.3s="checkDiiaStatus" @endif>

        <h2 class="text-xl font-bold text-gray-800">Згода на використання фотоматеріалів</h2>

        @if($consent->doctorPhoto?->path)
            <div class="border rounded-xl p-3 bg-gray-50">
                <img src="{{ Storage::url($consent->doctorPhoto->path) }}" class="max-h-64 mx-auto rounded-lg shadow-sm" alt="Фото для згоди">
            </div>
        @endif

        <div class="text-sm text-gray-600 text-left space-y-2 bg-blue-50 p-4 rounded-xl border border-blue-100">
            <p>Я надаю дозвіл на використання та публікацію вищевказаних фотоматеріалів у медичних та інформаційних цілях.</p>
        </div>

        @if($signStatus === 'signed' || $consent->status === 'signed')
            {{-- Успішно підписано --}}
            <div class="p-6 bg-green-50 border border-green-200 rounded-2xl space-y-3">
                <div class="text-green-800 font-bold text-lg flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Документ успішно підписано!
                </div>
                @if($consent->pdf_path)
                    <div class="pt-2">
                        <a href="{{ Storage::disk('public')->url($consent->pdf_path) }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                            Завантажити підписаний PDF
                        </a>
                    </div>
                @endif
            </div>

        @elseif($signStatus === 'expired')
            {{-- Сесія вичерпана --}}
            <div class="p-6 bg-amber-50 border border-amber-200 rounded-2xl space-y-3">
                <div class="text-amber-800 font-bold text-base">
                    Час дії QR-коду вичерпано (3 хвилини)
                </div>
                <p class="text-xs text-amber-700">
                    Опитування припинено. Натисніть кнопку нижче, щоб згенерувати новий QR-код для підпису.
                </p>
                <div class="pt-2">
                    <button wire:click="retrySign" class="px-5 py-2.5 bg-black text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition">
                        Оновити QR-код
                    </button>
                </div>
            </div>

        @else
            {{-- В процесі підписання --}}
            <div class="space-y-4">
                <p class="text-sm font-medium text-gray-700">Відскануйте QR-код застосунком Дія для підпису:</p>
                
                @if($qrCodeUrl)
                    <div class="inline-block p-3 bg-white border-2 border-black rounded-2xl shadow">
                        @if(str_starts_with($qrCodeUrl, '<svg'))
                            {!! $qrCodeUrl !!}
                        @else
                            <img src="{{ $qrCodeUrl }}" alt="Дія.Підпис QR" class="w-56 h-56 mx-auto">
                        @endif
                    </div>
                @endif
{{-- ДОДАЄМО ТЕКСТОВИЙ DEEPLINK ДЛЯ ВІДЛАГОДЖЕННЯ ТУТ --}}
                @if($deepLink)
                    <div class="px-4">
                        <p class="text-[10px] text-gray-400 uppercase font-mono tracking-wider mb-1">DeepLink для Дія:</p>
                        <p class="text-xs break-all text-gray-500 font-mono bg-gray-50 p-2 rounded-lg border border-gray-200 select-all">
                            {{ $deepLink }}
                        </p>
                    </div>
                @endif
                @if($deepLink)
                    <div class="block sm:hidden pt-2">
                        <a href="{{ $deepLink }}" target="_blank" class="block w-full py-3 bg-black text-white rounded-xl font-semibold text-sm hover:bg-gray-800">
                            Підписати в застосунку Дія
                        </a>
                    </div>
                @endif

                <div x-data="{ 
                        expiresAt: {{ $expiresAt }},
                        timeLeft: 180,
                        formatTime() {
                            const m = Math.floor(this.timeLeft / 60);
                            const s = this.timeLeft % 60;
                            return `${m}:${s < 10 ? '0' : ''}${s}`;
                        }
                    }" 
                    x-init="
                        timeLeft = Math.max(0, expiresAt - Math.floor(Date.now() / 1000));
                        setInterval(() => {
                            timeLeft = Math.max(0, expiresAt - Math.floor(Date.now() / 1000));
                        }, 1000);
                    "
                    class="text-xs text-gray-500 flex items-center justify-center gap-2 mt-2">
                    
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    
                    <span>Очікування підтвердження з Дії... (Дійсний ще: <strong x-text="formatTime()"></strong>)</span>
                </div>
            </div>
        @endif
    </div>
</div>