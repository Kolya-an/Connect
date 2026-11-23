<div class="_flex-display _justify-content-between spec_register1_right_block">
    <div class="_flex-display _align-center spec_register1_right_forms">
        <h5>{{__('Додайте селфі з документом, що посвідчує особу')}}</h5>
        <p>{{__('(паспорт громадянина України або закордонний паспорт)')}}</p>
        <p>{{__('Завантажуючи ці документи, я гарантую їхню справжність та усвідомлюю, що використання підроблених документів тягне за собою кримінальну відповідальність за ст. 358 Кримінального кодексу України. Я погоджуюсь, що Платформа має право передати мої ідентифікаційні дані правоохоронним органам у разі виявлення ознак підробки')}}</p>
    </div>
    <div class="_flex-display _align-center spec_register1_right_photos">
        <h5>{{__('Селфі з документом') }}</h5>
        
        @if ($passportPhoto)
            <!-- Додано wire:click та стилі курсору, щоб можна було клікнути і видалити -->
            <div  class="photo_item_img" wire:click="deletePassport"> 
                <img src="{{ asset('uploads/' . $passportPhoto) }}" 
                    alt="Passport Photo" 
                    wire:click="deletePassport" 
                    title="{{ __('Клікніть, щоб видалити фото') }}"
                    style="cursor: pointer; max-height: 150px; object-fit: cover;" />
                <div class="_flex-display _justify-content-center _align-center delete_image _display_none">
                    <svg width="23" height="29" viewBox="0 0 23 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.58333 25.3333C1.58333 26.1732 1.91696 26.9786 2.51083 27.5725C3.10469 28.1664 3.91015 28.5 4.75 28.5H17.4167C18.2565 28.5 19.062 28.1664 19.6558 27.5725C20.2497 26.9786 20.5833 26.1732 20.5833 25.3333V6.33333H1.58333V25.3333ZM4.75 9.5H17.4167V25.3333H4.75V9.5ZM16.625 1.58333L15.0417 0H7.125L5.54167 1.58333H0V4.75H22.1667V1.58333H16.625Z" fill="white"/>
                    </svg>
                </div>
            </div>
        @endif

        <button onclick="document.getElementById('passport-input').click()" class="_flex-display _justify-content-center _align-center btn white_rose_btn add_btn add_photo">
            <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                <rect id="ic:round-plus" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                <path id="Vector" d="M13 8L8 8L8 13C8 13.2652 7.89464 13.5196 7.70711 13.7071C7.51957 13.8946 7.26522 14 7 14C6.73478 14 6.48043 13.8946 6.29289 13.7071C6.10536 13.5196 6 13.2652 6 13L6 8L1 8C0.734784 8 0.48043 7.89464 0.292893 7.70711C0.105357 7.51957 0 7.26522 0 7C0 6.73478 0.105357 6.48043 0.292893 6.29289C0.48043 6.10536 0.734784 6 1 6L6 6L6 1C6 0.734784 6.10536 0.480429 6.29289 0.292893C6.48043 0.105357 6.73478 -8.88178e-16 7 0C7.26522 -8.88178e-16 7.51957 0.105357 7.70711 0.292893C7.89464 0.480429 8 0.734784 8 1L8 6L13 6C13.2652 6 13.5196 6.10536 13.7071 6.29289C13.8946 6.48043 14 6.73478 14 7C14 7.26522 13.8946 7.51957 13.7071 7.70711C13.5196 7.89464 13.2652 8 13 8Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
            </svg> {{__('Додати фото до 4Мб')}}
        </button>
        
        <input type="file" id="passport-input" style="display: none;" wire:model="passportFile" class="hidden" accept="image/*">
        @error('passportFile')
            <div style="color: #d92d20; font-size: 13px; margin-top: 6px;">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>