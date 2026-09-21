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
        <div class="p-4 bg-green-100 text-green-800 rounded-xl font-semibold">
            ✓ Цю згоду успішно підписано КЕП через Дія.Підпис!
        </div>
        @if($consent->pdf_path)
            <div class="pt-2">
                <a href="{{ Storage::disk('public')->url($consent->pdf_path) }}" target="_blank" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700">
                    Завантажити підписаний PDF
                </a>
            </div>
        @endif
    @else
        <div class="space-y-4">
            <p class="text-sm font-medium text-gray-700">Відскануйте QR-код застосунком Дія для підпису:</p>
            
            @if($qrCodeUrl)
                <div class="inline-block p-3 bg-white border-2 border-black rounded-2xl shadow">
                    <img src="{{ $qrCodeUrl }}" alt="Дія.Підпис QR" class="w-56 h-56 mx-auto">
                </div>
            @endif

            @if($deepLink)
                <div class="block sm:hidden pt-2">
                    <a href="{{ $deepLink }}" target="_blank" class="block w-full py-3 bg-black text-white rounded-xl font-semibold text-sm hover:bg-gray-800">
                        Підписати в застосунку Дія
                    </a>
                </div>
            @endif

            <div class="text-xs text-gray-400 flex items-center justify-center gap-2 mt-2">
                <span class="animate-spin rounded-full h-3 w-3 border-b-2 border-gray-500"></span>
                Очікування підтвердження з Дії...
            </div>
        </div>
    @endif
</div>