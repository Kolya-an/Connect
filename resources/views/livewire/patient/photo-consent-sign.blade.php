<div class="container" style="max-width: 700px; margin: 40px auto; padding: 20px;">
    @if($consent->status === 'signed')
        <div class="alert alert-success" style="background: #e6fffa; border: 1px solid #319795; padding: 20px; border-radius: 8px;">
            <h3>✓ Згоду вже підписано!</h3>
            <p>Дякуємо. Ви підписали цю згоду <strong>{{ $consent->signed_at->format('d.m.Y H:i') }}</strong>.</p>
        </div>
    @elseif($consent->status === 'declined')
        <div class="alert alert-danger" style="background: #fff5f5; border: 1px solid #e53e3e; padding: 20px; border-radius: 8px;">
            <h3>Ви відхилили надання згоди.</h3>
        </div>
    @else
        <div class="card" style="box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 12px; padding: 30px; background: #fff;">
            <h2>Згода на публікацію фотографій</h2>
            <p><strong>Лікар:</strong> {{ $consent->photo->doctor->user->name ?? '' }} {{ $consent->photo->doctor->second_name ?? '' }}</p>

            <!-- Перегляд фото -->
            <div style="display: flex; gap: 10px; margin: 20px 0;">
                <img src="{{ asset('uploads/' . $consent->photo->photo_before) }}" style="width: 50%; border-radius: 8px;" alt="До">
                <img src="{{ asset('uploads/' . $consent->photo->photo_after) }}" style="width: 50%; border-radius: 8px;" alt="Після">
            </div>

            <!-- Текст офіційного документа -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; max-height: 200px; overflow-y: auto; font-size: 14px; margin-bottom: 20px;">
                <p>Я, надаю дозвіл лікарю на безстрокове розміщення зображень (фотографій "До" та "Після" процедури {{ $consent->photo->procedure }}) на веб-платформі Connect з метою демонстрації результатів процедури.</p>
                <p>Я підтверджую, що цей підпис здійснюється добровільно та має силу кваліфікованого електронного підпису (КЕП).</p>
            </div>

            <!-- Блок Підпису (КЕП / Дія.Підпис) -->
            <div id="sign-widget-container">
                <p><strong>Оберіть спосіб підпису:</strong></p>
                
                <!-- Інтеграція віджета Дія.Підпис або КЕП -->
                <button id="btn-sign-diia" class="btn rose_btn" style="width: 100%; padding: 12px; font-size: 16px;">
                    Підписати за допомогою Дія.Підпис / КЕП
                </button>
            </div>
        </div>
    @endif
</div>

