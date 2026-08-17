<div class="_flex-display _justify-content-between spec_register1_right_block">
    <div class="spec_register1_right_forms">
        <h5>{{__('Медична ліцензія')}}</h5>
        <p>{{__('Додайте фото медичної ліцензії (при її наявності)')}}</p>
    </div>
    <div class="spec_register1_right_photos">
        <h5>{{__('Ліцензія') }}</h5>
        @if ($licensyPhoto)
            <img src="{{ asset('uploads/' . $licensyPhoto) }}" alt="Licensy Photo">
        @endif
        <button onclick="document.getElementById('licensy-input').click()" class="_flex-display _justify-content-center _align-center btn white_rose_btn add_btn add_photo">
            <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                <rect id="ic:round-plus" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                <path id="Vector" d="M13 8L8 8L8 13C8 13.2652 7.89464 13.5196 7.70711 13.7071C7.51957 13.8946 7.26522 14 7 14C6.73478 14 6.48043 13.8946 6.29289 13.7071C6.10536 13.5196 6 13.2652 6 13L6 8L1 8C0.734784 8 0.48043 7.89464 0.292893 7.70711C0.105357 7.51957 0 7.26522 0 7C0 6.73478 0.105357 6.48043 0.292893 6.29289C0.48043 6.10536 0.734784 6 1 6L6 6L6 1C6 0.734784 6.10536 0.480429 6.29289 0.292893C6.48043 0.105357 6.73478 -8.88178e-16 7 0C7.26522 -8.88178e-16 7.51957 0.105357 7.70711 0.292893C7.89464 0.480429 8 0.734784 8 1L8 6L13 6C13.2652 6 13.5196 6.10536 13.7071 6.29289C13.8946 6.48043 14 6.73478 14 7C14 7.26522 13.8946 7.51957 13.7071 7.70711C13.5196 7.89464 13.2652 8 13 8Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
            </svg> {{__('Додати фото')}}
        </button>
        
        <!-- Використовуємо окрему властивість licensyFile -->
        <input type="file" id="licensy-input" style="display: none;" wire:model="licensyFile" class="hidden" accept="image/*">
    </div>
</div>
