@php use Carbon\Carbon; @endphp
<div class="spec_reviews">
    @if(!isset($messages) && $messages->count() == 0)
        <p>{{__('Немає активних записів.')}}</p>
    @else
        @foreach($messages as $message)
    <div class="_flex-display _justify-content-between spec_review">
        <div class="spec_review_left">
            <a class="rose_btn client_not_btn _maxwidth768">
                @if($message->status === 'confirmed')
                    {{__('Підтверджено')}}
                @elseif($message->status === 'canceled')
                    {{__('Скасовано')}}
                @endif
            </a>
            <h6>{{__('Ваш запис')}}:</h6>
            @if($message->doctor->types)
                <p><b>{{__('Спеціаліст')}}: </b>
                    @foreach($message->doctor->types as $type)
                        {{$type}}{{ $loop->last ? '' : ', ' }}
                    @endforeach
                </p>
            @endif
            <p><b>{{__('ПІБ')}}: </b>{{$message->doctor->second_name}} {{$message->doctor->user->name}}</p>
            @php
                Carbon::setLocale('uk');

                $date = Carbon::parse($message->appointment->date);

                // 1. День тижня (українською, з великої літери)
                $weekday = ucfirst($date->translatedFormat('l'));

                // 2. День з правильним закінченням
                $day = $date->day;
                $dayFormatted = $day == 1 ? '1-ше' : $day . '-го';

                // 3. Місяць у родовому відмінку
                $monthsGenitive = [
                    1 => 'січня',
                    2 => 'лютого',
                    3 => 'березня',
                    4 => 'квітня',
                    5 => 'травня',
                    6 => 'червня',
                    7 => 'липня',
                    8 => 'серпня',
                    9 => 'вересня',
                    10 => 'жовтня',
                    11 => 'листопада',
                    12 => 'грудня',
                ];

                $month = $monthsGenitive[$date->month];

                // 4. Рік
                $year = $date->year;
            @endphp

            <p><b>{{__('Дата')}}: </b>{{ $weekday }}, {{ $dayFormatted }} {{ $month }} {{ $year }}</p>
            <p><b>{{__('Час')}}: </b>{{$message->appointment->hour}}</p>
            <p><b>{{__('Адреса')}}: </b>{{$message->doctor->city}},  {{$message->doctor->address}}</p>
        </div>
        <a class="rose_btn client_not_btn _minwidth769">
            @if($message->status === 'confirmed')
                {{__('Підтверджено')}}
            @elseif($message->status === 'canceled')
                {{__('Скасовано')}}
            @endif
        </a>
    </div>
        @endforeach
    @endif

    @if ($messages->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            @if ($messages->onFirstPage())
            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
            @foreach ($messages->getUrlRange(1, $messages->lastPage()) as $page => $url)
                @if($page === $messages->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @endif
            @endforeach
            @if ($messages->hasMorePages())
                <li><a wire:click="nextPage" class="_flex-display _justify-content-center _align-center">
                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                        </svg>
                    </a>
                </li>
            @endif
        </ul>
    @endif
</div>
