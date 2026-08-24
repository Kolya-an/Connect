<div class="_flex-display _justify-content-between spec_about">
    <div class="spec_about_info">
        <div class="_flex-display _justify-content-between _align-stretch photo_list_block">
            @forelse($photos as $photo)
                <div class="photo_item">
                    <div class="photo_item_img">
                        <div class="_flex-display comparison-container {{ $photo->orientation === 'vertical' ? '_flex-column' : '_flex-row' }}">
                            <img src="{{ asset('uploads/'.$photo->photo_before) }}">
                            <img src="{{ asset('uploads/'.$photo->photo_after) }}">
                        </div>
                    </div>
                    <p><b>{{__('Процедура')}}:</b> {{ $photo->procedure }}</p>
                    <p><b>{{__('Клінічний кейс')}}:</b> {{ $photo->product }}</p>
                    <p>&nbsp;</p>
                    <button wire:click="openReportModal({{ $photo->id }})" class="btn rose_btn">{{__('Поскаржитися')}}</button>
                </div>
            @empty
                <p>Фото відсутні</p>
            @endforelse

        </div>
        <div id="disclamer" style="margin-top:20px;">
            <div class="container">
                <div class="disclamer_text" >
                    <p style="text-align:center;">
                        {{__('Потрібно проконсультуватися з лікарем перед застосуванням відповідного засобу чи виробу. Рекомендацію ознайомитися з інструкцією препарату. «Самолікування може бути шкідливим для вашого здоров’я».')}}
                    </p>
                    <p style="text-align:center;">
                        {{__('Матеріали мають інформаційно-освітній характер. Результат косметологічних процедур є індивідуальним та залежить від анатомічних особливостей пацієнта. Представлені матеріали не гарантують отримання аналогічного результату та не є рекламою медичних послуг')}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="spec_about_docs">
        <h4>{{__('Дипломи та сертифікати')}}</h4>
        <div class="_flex-display _justify-content-between spec_about_docs_list">
            @if(!empty($education_images))
                @foreach($education_images as $education_image)
                    <a href="#"><img src="{{ asset('uploads/education/'.$education_image) }}" alt=""></a>
                @endforeach
            @endif
            @if(!empty($extra_images))
                @foreach($extra_images as $extra_image)
                    <a href="#"><img src="{{ asset('uploads/extra/'.$extra_image) }}" alt=""></a>
                @endforeach
            @endif
        </div>
        <h4>{{__('Освіта')}}</h4>
        @forelse($educations as $education)
            <p><b>{{$education->title}}</b></p>
            <p><span>{{$education->period}}</span></p>
            <p>{{$education->desc}}</p>
        @empty
            <p>Заклади відсутні</p>
        @endforelse
        <h4>{{__('Додаткова освіта та сертифікати')}}</h4>
        @forelse($extras as $extra)
            <p><b>{{$extra->title}}</b></p>
            <p><span>{{$extra->period}}</span></p>
            <p>{{$extra->desc}}</p>
        @empty
            <p>Заклади відсутні</p>
        @endforelse
        <p>{{$doctor->desc}}</p>
    </div>
    <!-- Модальне вікно скарги -->
    @if($showReportModal)
        <div id="add_agree" class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_agree_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Поскаржитися на фото')}}</h4>
                    <div wire:click="closeReportModal" id="window_close" class="window_close cursor-pointer">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none">
                            <rect width="48" height="48" rx="24" fill="rgb(255,225,228)" />
                            <path d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </div>
                </div>
                <div class="spec_register1_right_block" style="margin:0">
                    <form wire:submit.prevent="sendReport">
                        <div style="margin-bottom: 15px;">
                            <textarea wire:model="reportText" class="form-control" rows="4" 
                                    placeholder="{{ __('Вкажіть причину скарги...') }}" 
                                    style="width: 100%; border-radius: 8px; padding: 10px; border: 1px solid #ccc;"></textarea>
                            @error('reportText') 
                                <span class="text-danger small" style="color: red; font-size: 12px;">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="_flex-display _justify-content-between" style="gap: 10px;">
                            <button type="button" wire:click="closeReportModal" class="btn white_rose_btn">{{ __('Скасувати') }}</button>
                            <button type="submit" class="btn rose_btn">{{ __('Відправити') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
