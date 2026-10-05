<div class="container mx-auto px-4">
    <h2 class="text-xl font-bold text-gray-800">Згода на використання фотоматеріалів</h2>
    <div class="_flex-display _align-center">
        
        <div style="flex: 1 1 calc(50% - 8px);">



     
     <p class="text-xs text-gray-600 leading-relaxed">
            Я надаю дозвіл на використання та публікацію вищевказаних фотоматеріалів у медичних та інформаційних цілях.
        </p>
    @if($signStatus === 'signed' || $consent->status === 'signed')
    {{-- Успішно підписано --}}
    <div class="p-6 bg-green-50 border border-green-200 rounded-2xl space-y-3" x-data x-init="
                setTimeout(() => { window.close(); }, 1500);
            ">
        <div class="text-green-800 font-bold text-lg flex items-center justify-center gap-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Документ успішно підписано!
        </div>
        <p class="text-xs text-green-700">Вікно можна закрити.</p>

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

        @if($deepLink)
        
        <div class="_maxwidth768">
            <a href="{{ $deepLink }}" target="_blank" class="block w-full py-3 bg-black text-white rounded-xl font-semibold text-sm hover:bg-gray-800">
                Підписати в застосунку Дія
            </a>
        </div>
        @endif

        <div x-data="{ 
                        expiresAt: {{ $expiresAt ?? 0 }},
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

            <span>QR-код дійсний ще 3:00</span>
        </div>
    </div>
    @endif
        </div>
    <div style="flex: 1 1 calc(50% - 8px);">
        @if($consent->doctorPhoto)
            @if($consent->doctorPhoto->photo_before || $consent->doctorPhoto->photo_after)
                <div style="display: flex; flex-direction: row; width: 320px; height: 320px; overflow: hidden;border-radius: 20px;float:left; margin-right: 16px; margin-bottom: 16px; border: 1px solid rgba(255,255,255,0.3);">
                    <div style="aspect-ratio: 1 / 1;">

                        <!-- Flex-ряд: 2 колонки строго по 50% ширини та 100% висоти -->
                        <div style="display: flex; width: 100%; height: 100%;">

                            <!-- Фото ДО (Left - 50%) -->
                            <div style="width: 50%; height: 100%; position: relative; border-right: 1px solid rgba(255,255,255,0.3);">
                                <img src="{{ asset('uploads/' . ltrim($consent->doctorPhoto->photo_before, '/')) }}" alt="Фото ДО" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">

                                <!--[if ENDBLOCK]><![endif]-->
                                <span class="absolute bottom-2 left-2 px-2 py-0.5 text-[11px] font-semibold text-white bg-black/60 backdrop-blur-sm rounded">
                                    ДО
                                </span>
                            </div>

                            <!-- Фото ПІСЛЯ (Right - 50%) -->
                            <div style="width: 50%; height: 100%; position: relative;">
                                <!--[if BLOCK]><![endif]--> <a href="{{ asset('uploads/' . ltrim($consent->doctorPhoto->photo_after, '/')) }}" target="_blank" style="display: block; width: 100%; height: 100%;">
                                    <img src="{{ asset('uploads/' . ltrim($consent->doctorPhoto->photo_after, '/')) }}" alt="Фото ПІСЛЯ" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">
                                </a>
                                <!--[if ENDBLOCK]><![endif]-->
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 text-[11px] font-semibold text-white bg-black/60 backdrop-blur-sm rounded">
                                    ПІСЛЯ
                                </span>
                            </div>

                        </div>
                    </div>
                <!--[if ENDBLOCK]><![endif]-->
            </div>
            @endif
        @endif
    
        <div>
            {{-- Інформація про лікаря --}}
            @if($consent->doctorPhoto?->doctor)
            @php
            $doctor = $consent->doctorPhoto->doctor;
            $doctorName = $doctor->name ?? $doctor->user?->name ?? '';
            $doctorSecondName = $doctor->second_name ?? '';
            @endphp
            <div class="flex items-center justify-between">
                <span class="text-gray-500 font-medium">Лікар:</span>
                <span class="font-semibold text-gray-900">
                    {{ trim("{$doctorName} {$doctorSecondName}") }}
                </span>
            </div>
            @endif

            {{-- Процедура --}}
            @if($consent->doctorPhoto?->procedure)
            <div class="flex items-center justify-between">
                <span class="text-gray-500 font-medium">Процедура:</span>
                <span class="font-semibold text-gray-900">{{ $consent->doctorPhoto->procedure }}</span>
            </div>
            @endif

            {{-- Препарат / Продукт --}}
            @if($consent->doctorPhoto?->product)
            <div class="flex items-center justify-between">
                <span class="text-gray-500 font-medium">Препарат/Продукт:</span>
                <span class="font-semibold text-gray-900">{{ $consent->doctorPhoto->product }}</span>
            </div>
            @endif

        </div>

       </div>
    </div>
</div>
