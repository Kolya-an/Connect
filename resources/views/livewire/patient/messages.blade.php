@php use Carbon\Carbon; @endphp
<div class="spec_reviews">
    <!-- Таби -->
    <div class="_flex-display _justify-content-center _align-center" style="margin-bottom: 20px; gap: 10px;">
        <button wire:click="switchTab('messages')" class="btn {{ $activeTab === 'messages' ? 'rose_btn' : 'white_rose_btn' }}">
            {{__('Повідомлення')}}
        </button>
        <button wire:click="switchTab('notifications')" class="btn {{ $activeTab === 'notifications' ? 'rose_btn' : 'white_rose_btn' }}" style="position: relative;">
            {{__('Акції')}}
            @if($unreadCount > 0)
                <span style="position: absolute; top: -5px; right: -5px; background: #f396a2; color: #fff; border-radius: 50%; width: 20px; height: 20px; font-size: 11px; display: flex; align-items: center; justify-content: center;">{{ $unreadCount }}</span>
            @endif
        </button>
    </div>

    @if($activeTab === 'messages')
        <!-- Повідомлення (записи) -->
        @if(!isset($messages) || $messages->count() == 0)
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
                            $weekday = ucfirst($date->translatedFormat('l'));
                            $day = $date->day;
                            $dayFormatted = $day == 1 ? '1-ше' : $day . '-го';
                            $monthsGenitive = [
                                1 => 'січня', 2 => 'лютого', 3 => 'березня', 4 => 'квітня',
                                5 => 'травня', 6 => 'червня', 7 => 'липня', 8 => 'серпня',
                                9 => 'вересня', 10 => 'жовтня', 11 => 'листопада', 12 => 'грудня',
                            ];
                            $month = $monthsGenitive[$date->month];
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
    @elseif($activeTab === 'notifications')
        <!-- Сповіщення (акції) -->
        @if(!isset($notifications) || $notifications->count() == 0)
            <p>{{__('Немає сповіщень.')}}</p>
        @else
            @foreach($notifications as $notification)
                <div class="_flex-display _justify-content-between spec_review" style="{{ $notification->is_read ? '' : 'border-left: 4px solid #f396a2; background: rgba(243, 150, 162, 0.05);' }}">
                    <div class="spec_review_left">
                        <div class="_flex-display _align-center" style="gap: 10px; margin-bottom: 10px;">
                            @if(!$notification->is_read)
                                <span style="background: #f396a2; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 11px;">{{__('Нове')}}</span>
                            @endif
                            <span style="color: #999; font-size: 12px;">{{ $notification->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <h6>{{ $notification->title }}</h6>
                        @if($notification->doctor)
                            <p><b>{{__('Лікар')}}: </b>{{ $notification->doctor->user->name }} {{ $notification->doctor->second_name }}</p>
                        @endif
                        <p style="white-space: pre-line;">{{ $notification->message }}</p>
                        @if($notification->promotion)
                            <div class="spec_action_price" style="margin-top: 10px;">
                                <p>
                                    @if($notification->promotion->old_price)
                                        <span>{{ number_format($notification->promotion->old_price, 0, '.', ' ') }}₴</span>
                                    @endif
                                    @if($notification->promotion->new_price)
                                        {{ number_format($notification->promotion->new_price, 0, '.', ' ') }}₴
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="_flex-display _align-center" style="gap: 8px;">
                        @if(!$notification->is_read)
                            <button wire:click="markAsRead({{ $notification->id }})" class="btn white_rose_btn" style="font-size: 11px; padding: 5px 10px;">{{__('Прочитано')}}</button>
                        @endif
                        <button wire:click="deleteNotification({{ $notification->id }})" class="btn white_rose_btn" style="font-size: 11px; padding: 5px 10px;">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none">
                                <path d="M11.9999 12.6417L9.75404 14.8875C9.67001 14.9715 9.56306 15.0135 9.4332 15.0135C9.30334 15.0135 9.1964 14.9715 9.11237 14.8875C9.02834 14.8035 8.98633 14.6965 8.98633 14.5667C8.98633 14.4368 9.02834 14.3299 9.11237 14.2458L11.3582 12L9.11237 9.75416C9.02834 9.67013 8.98633 9.56319 8.98633 9.43332C8.98633 9.30346 9.02834 9.19652 9.11237 9.11249C9.1964 9.02846 9.30334 8.98645 9.4332 8.98645C9.56306 8.98645 9.67001 9.02846 9.75404 9.11249L11.9999 11.3583L14.2457 9.11249C14.3297 9.02846 14.4367 8.98645 14.5665 8.98645C14.6964 8.98645 14.8033 9.02846 14.8874 9.11249C14.9714 9.19652 15.0134 9.30346 15.0134 9.43332C15.0134 9.56319 14.9714 9.67013 14.8874 9.75416L12.6415 12L14.8874 14.2458C14.9714 14.3299 15.0134 14.4368 15.0134 14.5667C15.0134 14.6965 14.9714 14.8035 14.8874 14.8875C14.8033 14.9715 14.6964 15.0135 14.5665 15.0135C14.4367 15.0135 14.3297 14.9715 14.2457 14.8875L11.9999 12.6417Z" fill="rgb(0,0,0)"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif

        @if ($notifications->hasPages())
            <ul class="_flex-display _justify-content-center _align-center pagination">
                @if ($notifications->onFirstPage())
                @else
                    <li><a wire:click="previousPage('notifications_page')" class="_flex-display _justify-content-center _align-center"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                            </svg>
                        </a></li>
                @endif
                @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                    @if($page === $notifications->currentPage())
                        <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                    @else
                        <li><a wire:click="gotoPage({{ $page }}, 'notifications_page')" class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                    @endif
                @endforeach
                @if ($notifications->hasMorePages())
                    <li><a wire:click="nextPage('notifications_page')" class="_flex-display _justify-content-center _align-center">
                            <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                                <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                            </svg>
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    @endif
</div>
