<div class="_flex-display _justify-content-between spec_about">
    <div class="spec_about_info">
        <div class="_flex-display _justify-content-between _align-stretch photo_list_block">
            @forelse($photos as $photo)
                <div class="photo_item">
                    <a class="photo_item_img"><img src="{{ asset('uploads/'.$photo->photo) }}" alt=""></a>
                    <p><b>{{__('Процедура')}}:</b> {{ $photo->procedure }}</p>
                    <p><b>{{__('Препарат')}}:</b> {{ $photo->product }}</p>
                </div>
            @empty
                <p>Фото відсутні</p>
            @endforelse

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
</div>
