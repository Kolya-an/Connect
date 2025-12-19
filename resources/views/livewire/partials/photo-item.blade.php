<div class="photo_item">
    <a href="/doctors/{{$photo['doctor']['user']['id']}}" class="photo_item_img">
        <div class="_flex-display comparison-container {{ $photo['orientation'] === 'vertical' ? '_flex-column' : '_flex-row' }}">
            <img src="{{ asset('uploads/' . $photo['photo_before']) }}" alt="{{ $photo['procedure'] }}">
            <img src="{{ asset('uploads/' . $photo['photo_after']) }}" alt="{{ $photo['procedure'] }}">
        </div>
    </a>
    @if(!empty($photo['doctor']['types']) && is_array($photo['doctor']['types']))
        <p><b>
                @foreach($photo['doctor']['types'] as $type)
                    {{ $type }}@if(!$loop->last), @endif
                @endforeach
            </b></p>
    @endif

    <a href="/doctors/{{$photo['doctor']['user']['id']}}" class="photo_name">{{ $photo['doctor']['second_name'] }} {{ $photo['doctor']['user']['name'] }}</a>

    <div class="_flex-display _justify-content-between _align-center top_docs-rating_city">

        @if ($photo['doctor']['reviews_count'] > 0)
            <div class="_flex-display _align-bottom top_docs-rating">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.71468 0.378114C6.80449 0.101721 7.19551 0.101722 7.28532 0.378115L8.72876 4.82057C8.76892 4.94418 8.88411 5.02786 9.01408 5.02786H13.6851C13.9758 5.02786 14.0966 5.39975 13.8615 5.57057L10.0825 8.31616C9.97736 8.39255 9.93336 8.52796 9.97352 8.65157L11.417 13.094C11.5068 13.3704 11.1904 13.6003 10.9553 13.4294L7.17634 10.6838C7.07119 10.6074 6.92881 10.6075 6.82366 10.6838L3.04469 13.4294C2.80957 13.6003 2.49323 13.3704 2.58303 13.094L4.02648 8.65157C4.06664 8.52796 4.02264 8.39255 3.91749 8.31616L0.138516 5.57057C-0.0965979 5.39975 0.0242358 5.02786 0.314853 5.02786H4.98593C5.11589 5.02786 5.23108 4.94418 5.27124 4.82057L6.71468 0.378114Z" fill="#F396A2"></path>
                </svg>
                <p><b>{{ $photo['doctor']['rating'] }}</b> ({{ $photo['doctor']['reviews_count'] }})</p>
            </div>
        @endif
        <div class="_flex-display _align-bottom top_docs-city">
            <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 5.6004C7 4.77164 6.32846 4.1001 5.5003 4.1001C4.67154 4.1001 4 5.6004 4 5.6004C4 6.42856 4.67154 7.1001 5.5003 7.1001C6.32846 7.1001 7 6.42856 7 5.6004Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.49971 11.9001C4.78062 11.9001 1 8.83912 1 5.63807C1 3.13208 3.01426 1.1001 5.49971 1.1001C7.98515 1.1001 10 3.13208 10 5.63807C10 8.83912 6.21879 11.9001 5.49971 11.9001Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <p><b>м. {{ $photo['doctor']['city'] }}</b></p>
        </div>
    </div>

    @if($photo['procedure'])
        <p><b>{{__('Процедура')}}:</b> {{ $photo['procedure'] }}</p>
    @endif

    @if($photo['product'])
        <p><b>{{__('Препарат')}}:</b> {{ $photo['product'] }}</p>
    @endif
</div>
