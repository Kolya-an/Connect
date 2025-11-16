<div class="spec_reviews">
    @if(!isset($appointments) && $appointments->count() == 0)
        <p>{{__('Немає активних записів.')}}</p>
    @else
        @foreach($appointments as $appointment)
            <div class="spec_review">
                <div class="_flex-display _justify-content-between spec_review_top">
                    <div class="_flex-display _align-center spec_review_left">
                        <div class="spec_review_image"><img src="{{ asset('uploads/' . $appointment->doctor->photo) }}" alt="{{ $appointment->doctor->second_name }} {{ $appointment->doctor->user->name }}"></div>
                        <div class="spec_review_name_stars">
                            <div class="spec_review_date _maxwidth768">
                                <div class="_flex-display _align-center client_date">
                                    <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                                        <rect id="mingcute:time-line" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                        <g id="Group">
                                            <path id="Vector" d="M7.34651 13.5674L7.34009 13.5686L7.29867 13.589L7.287 13.5913L7.27884 13.589L7.23742 13.5686C7.2312 13.5666 7.22653 13.5676 7.22342 13.5715L7.22109 13.5773L7.21117 13.827L7.21409 13.8387L7.21992 13.8462L7.28059 13.8894L7.28934 13.8917L7.29634 13.8894L7.35701 13.8462L7.36401 13.8369L7.36634 13.827L7.35642 13.5779C7.35487 13.5717 7.35156 13.5682 7.34651 13.5674ZM7.50109 13.5015L7.49351 13.5027L7.38559 13.5569L7.37976 13.5627L7.37801 13.5692L7.3885 13.82L7.39142 13.827L7.39609 13.8311L7.51334 13.8853C7.52073 13.8873 7.52637 13.8857 7.53025 13.8807L7.53259 13.8725L7.51276 13.5143C7.51081 13.5073 7.50692 13.5031 7.50109 13.5015ZM7.084 13.5027C7.08143 13.5011 7.07836 13.5006 7.07543 13.5013C7.07249 13.5019 7.06992 13.5037 7.06826 13.5062L7.06475 13.5143L7.04492 13.8725C7.04531 13.8795 7.04862 13.8842 7.05484 13.8865L7.06359 13.8853L7.18084 13.8311L7.18667 13.8264L7.189 13.82L7.19892 13.5692L7.19717 13.5622L7.19134 13.5563L7.084 13.5027Z" fill-rule="nonzero" />
                                            <path id="Vector" d="M6.99935 1.16699C10.2211 1.16699 12.8327 3.77858 12.8327 7.00032C12.8327 10.2221 10.2211 12.8337 6.99935 12.8337C3.7776 12.8337 1.16602 10.2221 1.16602 7.00032C1.16602 3.77858 3.7776 1.16699 6.99935 1.16699ZM6.99935 2.33366C5.76167 2.33366 4.57469 2.82532 3.69952 3.70049C2.82435 4.57566 2.33268 5.76265 2.33268 7.00032C2.33268 8.238 2.82435 9.42499 3.69952 10.3002C4.57469 11.1753 5.76167 11.667 6.99935 11.667C8.23703 11.667 9.42401 11.1753 10.2992 10.3002C11.1743 9.42499 11.666 8.238 11.666 7.00032C11.666 5.76265 11.1743 4.57566 10.2992 3.70049C9.42401 2.82532 8.23703 2.33366 6.99935 2.33366ZM6.99935 3.50033C7.14223 3.50034 7.28013 3.5528 7.3869 3.64774C7.49367 3.74269 7.56188 3.87351 7.5786 4.01541L7.58268 4.08366L7.58268 6.75882L9.16176 8.33791C9.26638 8.44288 9.32712 8.58374 9.33165 8.73188C9.33617 8.88002 9.28414 9.02432 9.18612 9.13549C9.0881 9.24665 8.95144 9.31634 8.8039 9.33039C8.65637 9.34445 8.50901 9.30182 8.39176 9.21116L8.33693 9.16274L6.58693 7.41274C6.49627 7.322 6.43804 7.20391 6.42126 7.07674L6.41601 7.00032L6.41601 4.08366C6.41601 3.92895 6.47747 3.78058 6.58687 3.67118C6.69627 3.56178 6.84464 3.50033 6.99935 3.50033Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                    <span>{{ optional($appointment->date)->format('d.m.Y') }} - {{ $appointment->hour }}</span>
                                </div>
                            </div>
                            <p>{{ $appointment->doctor->second_name }} {{ $appointment->doctor->user->name }}</p>
                            @if($appointment->doctor->types)
                                <p class="client_spec"><span>
                                                    @foreach($appointment->doctor->types as $type)
                                            {{$type}}{{ $loop->last ? '' : ', ' }}
                                        @endforeach
                                                </span></p>
                            @endif
                            <p class="client_address _minwidth769"><span>{{__('Адреса')}}:</span> {{ $appointment->doctor->city }},  {{ $appointment->doctor->address }}<br>
                                <span>{{__('Статус')}}: </span>
                                @if($appointment->status === 'canceled')
                                    {{__('Скасовано')}}
                                @elseif($appointment->status === 'completed')
                                    {{__('Завершено')}}
                                @endif
                            </p>
                            @if(optional($appointment->review)->text)
                                <p class="client_address _minwidth769">
                                    <span>{{__('Відгук')}}: </span>{{ $appointment->review->text }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <p class="client_address _maxwidth768"><span>{{__('Адреса')}}:</span> {{ $appointment->doctor->city }},  {{ $appointment->doctor->address }}<br>
                        <span>{{__('Статус')}}: </span>
                        @if($appointment->status === 'canceled')
                            {{__('Скасовано')}}
                        @elseif($appointment->status === 'completed')
                            {{__('Завершено')}}
                        @endif
                    </p>
                    @if(optional($appointment->review)->text)
                        <p class="client_address _maxwidth768">
                            <span>{{__('Відгук')}}: </span>{{ $appointment->review->text }}
                        </p>
                    @endif
                    <a wire:click.prevent="showModal({{ $appointment->id }})" class="white_rose_btn register_prev _maxwidth768">{{__('Залишити відгук')}}</a>

                    <div class="spec_review_date _minwidth769">
                        <div class="_flex-display _justify-content-end _align-center client_date">
                            <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14.000000" height="14.000000" fill="none">
                                <rect id="mingcute:time-line" width="14.000000" height="14.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <g id="Group">
                                    <path id="Vector" d="M7.34651 13.5674L7.34009 13.5686L7.29867 13.589L7.287 13.5913L7.27884 13.589L7.23742 13.5686C7.2312 13.5666 7.22653 13.5676 7.22342 13.5715L7.22109 13.5773L7.21117 13.827L7.21409 13.8387L7.21992 13.8462L7.28059 13.8894L7.28934 13.8917L7.29634 13.8894L7.35701 13.8462L7.36401 13.8369L7.36634 13.827L7.35642 13.5779C7.35487 13.5717 7.35156 13.5682 7.34651 13.5674ZM7.50109 13.5015L7.49351 13.5027L7.38559 13.5569L7.37976 13.5627L7.37801 13.5692L7.3885 13.82L7.39142 13.827L7.39609 13.8311L7.51334 13.8853C7.52073 13.8873 7.52637 13.8857 7.53025 13.8807L7.53259 13.8725L7.51276 13.5143C7.51081 13.5073 7.50692 13.5031 7.50109 13.5015ZM7.084 13.5027C7.08143 13.5011 7.07836 13.5006 7.07543 13.5013C7.07249 13.5019 7.06992 13.5037 7.06826 13.5062L7.06475 13.5143L7.04492 13.8725C7.04531 13.8795 7.04862 13.8842 7.05484 13.8865L7.06359 13.8853L7.18084 13.8311L7.18667 13.8264L7.189 13.82L7.19892 13.5692L7.19717 13.5622L7.19134 13.5563L7.084 13.5027Z" fill-rule="nonzero" />
                                    <path id="Vector" d="M6.99935 1.16699C10.2211 1.16699 12.8327 3.77858 12.8327 7.00032C12.8327 10.2221 10.2211 12.8337 6.99935 12.8337C3.7776 12.8337 1.16602 10.2221 1.16602 7.00032C1.16602 3.77858 3.7776 1.16699 6.99935 1.16699ZM6.99935 2.33366C5.76167 2.33366 4.57469 2.82532 3.69952 3.70049C2.82435 4.57566 2.33268 5.76265 2.33268 7.00032C2.33268 8.238 2.82435 9.42499 3.69952 10.3002C4.57469 11.1753 5.76167 11.667 6.99935 11.667C8.23703 11.667 9.42401 11.1753 10.2992 10.3002C11.1743 9.42499 11.666 8.238 11.666 7.00032C11.666 5.76265 11.1743 4.57566 10.2992 3.70049C9.42401 2.82532 8.23703 2.33366 6.99935 2.33366ZM6.99935 3.50033C7.14223 3.50034 7.28013 3.5528 7.3869 3.64774C7.49367 3.74269 7.56188 3.87351 7.5786 4.01541L7.58268 4.08366L7.58268 6.75882L9.16176 8.33791C9.26638 8.44288 9.32712 8.58374 9.33165 8.73188C9.33617 8.88002 9.28414 9.02432 9.18612 9.13549C9.0881 9.24665 8.95144 9.31634 8.8039 9.33039C8.65637 9.34445 8.50901 9.30182 8.39176 9.21116L8.33693 9.16274L6.58693 7.41274C6.49627 7.322 6.43804 7.20391 6.42126 7.07674L6.41601 7.00032L6.41601 4.08366C6.41601 3.92895 6.47747 3.78058 6.58687 3.67118C6.69627 3.56178 6.84464 3.50033 6.99935 3.50033Z" fill="rgb(243,150,162)" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <span>{{ $appointment->date }} - {{ $appointment->hour }}</span>
                        </div>
                        @if(!$appointment->review)
                            <a wire:click.prevent="showModal({{ $appointment->id }})" class="white_rose_btn register_prev">{{__('Залишити відгук')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @if ($appointments->hasPages())
        <ul class="_flex-display _justify-content-center _align-center pagination">
            @if ($appointments->onFirstPage())
            @else
                <li><a wire:click="previousPage" class="_flex-display _justify-content-center _align-center"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                            <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                            <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                        </svg>
                    </a></li>
            @endif
            @foreach ($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
                @if($page === $appointments->currentPage())
                    <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @else
                    <li><a wire:click="gotoPage({{ $page }})" class="_flex-display _justify-content-center _align-center">{{ $page }}</a></li>
                @endif
            @endforeach
            @if ($appointments->hasMorePages())
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
    @if($modalVisible)
        <div id="add_city" class="_flex-display _justify-content-center _align-center screen">
            <div class="window add_info_window">
                <div class="_flex-display _justify-content-between _align-center window_top">
                    <h4>{{__('Бажаєте скасувати візит?')}}</h4>
                    <div wire:click="closeModal" id="window_close" class="window_close">
                        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48.000000" height="48.000000" fill="none" clip-path="url(#clipPath_6)" customFrame="url(#clipPath_6)">
                            <defs>
                                <clipPath id="clipPath_6">
                                    <rect width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                                <clipPath id="clipPath_7">
                                    <rect width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" />
                                </clipPath>
                            </defs>
                            <rect id="Frame 1153" width="48.000000" height="48.000000" x="0.000000" y="0.000000" rx="24.000000" fill="rgb(255,225,228)" />
                            <g id="material-symbols:close-rounded" clip-path="url(#clipPath_7)" customFrame="url(#clipPath_7)">
                                <rect id="material-symbols:close-rounded" width="28.000000" height="28.000000" x="10.000000" y="10.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                                <path id="Vector" d="M24.0009 25.6333L18.2842 31.3499C18.0704 31.5638 17.7981 31.6708 17.4676 31.6708C17.137 31.6708 16.8648 31.5638 16.6509 31.3499C16.437 31.136 16.3301 30.8638 16.3301 30.5333C16.3301 30.2027 16.437 29.9305 16.6509 29.7166L22.3676 23.9999L16.6509 18.2833C16.437 18.0694 16.3301 17.7972 16.3301 17.4666C16.3301 17.136 16.437 16.8638 16.6509 16.6499C16.8648 16.436 17.137 16.3291 17.4676 16.3291C17.7981 16.3291 18.0704 16.436 18.2842 16.6499L24.0009 22.3666L29.7176 16.6499C29.9315 16.436 30.2037 16.3291 30.5342 16.3291C30.8648 16.3291 31.137 16.436 31.3509 16.6499C31.5648 16.8638 31.6717 17.136 31.6717 17.4666C31.6717 17.7972 31.5648 18.0694 31.3509 18.2833L25.6342 23.9999L31.3509 29.7166C31.5648 29.9305 31.6717 30.2027 31.6717 30.5333C31.6717 30.8638 31.5648 31.136 31.3509 31.3499C31.137 31.5638 30.8648 31.6708 30.5342 31.6708C30.2037 31.6708 29.9315 31.5638 29.7176 31.3499L24.0009 25.6333Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                            </g>
                        </svg>
                    </div>
                    <form wire:submit.prevent="cancelAppointment">
                        <div class="spec_register1_right_block" style="margin:0">
                            <textarea
                                class="add_desc_vuz"
                                wire:model.defer="text"
                                placeholder="{{__('Ваш відгук')}}..."
                            ></textarea>
                        </div>


                        <div class="_flex-display _justify-content-between _align-center">
                            <div><p class="client_address" style="margin:0"> {{__('Оцінка медичної частини')}}:</p></div>
                            <div class="_flex-display _justify-content-end _align-center" style="gap:20px">
                                <div class="_flex-display _justify-content-end _align-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg wire:click="setMedical({{ $i }})"
                                             wire:model.defer="medical"
                                            width="14" height="14" viewBox="0 0 14 14"
                                             fill="{{ $i <= $medical ? '#F8C400' : '#DDD' }}"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.70101 0.207216C6.79082 -0.0691775 7.18184 -0.0691764 7.27165 0.207217L8.71509 4.64967C8.75525 4.77328 8.87043 4.85697 9.0004 4.85697H13.6715C13.9621 4.85697 14.0829 5.22885 13.8478 5.39967L10.0688 8.14526C9.96369 8.22165 9.91969 8.35706 9.95985 8.48067L11.4033 12.9231C11.4931 13.1995 11.1768 13.4294 10.9416 13.2585L7.16266 10.5129C7.05752 10.4366 6.91514 10.4366 6.80999 10.5129L3.03101 13.2585C2.7959 13.4294 2.47956 13.1995 2.56936 12.9231L4.0128 8.48067C4.05297 8.35706 4.00897 8.22165 3.90382 8.14526L0.124844 5.39967C-0.11027 5.22885 0.010564 4.85697 0.301181 4.85697H4.97225C5.10222 4.85697 5.21741 4.77328 5.25757 4.64967L6.70101 0.207216Z" fill="#F396A2"/>
                                        </svg>

                                    @endfor
                                </div>
                                <div class="ml-2 font-bold text-gray-700">{{ $medical }}</div>
                            </div>
                        </div>

                        @error('medical') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                        <!-- Service рейтинг -->
                        <div class="_flex-display _justify-content-between _align-center">
                           <div><p class="client_address" style="margin:0"> {{__('Оцінка сервісу')}}:</p></div>
                            <div class="_flex-display _justify-content-end _align-center" style="gap:20px">
                                <div class="_flex-display _justify-content-end _align-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg wire:click="setService({{ $i }})"
                                             wire:model.defer="service"
                                            width="14" height="14" viewBox="0 0 14 14"
                                             fill="{{ $i <= $service ? '#F8C400' : '#DDD' }}"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.70101 0.207216C6.79082 -0.0691775 7.18184 -0.0691764 7.27165 0.207217L8.71509 4.64967C8.75525 4.77328 8.87043 4.85697 9.0004 4.85697H13.6715C13.9621 4.85697 14.0829 5.22885 13.8478 5.39967L10.0688 8.14526C9.96369 8.22165 9.91969 8.35706 9.95985 8.48067L11.4033 12.9231C11.4931 13.1995 11.1768 13.4294 10.9416 13.2585L7.16266 10.5129C7.05752 10.4366 6.91514 10.4366 6.80999 10.5129L3.03101 13.2585C2.7959 13.4294 2.47956 13.1995 2.56936 12.9231L4.0128 8.48067C4.05297 8.35706 4.00897 8.22165 3.90382 8.14526L0.124844 5.39967C-0.11027 5.22885 0.010564 4.85697 0.301181 4.85697H4.97225C5.10222 4.85697 5.21741 4.77328 5.25757 4.64967L6.70101 0.207216Z" fill="#F396A2"/>
                                        </svg>
                                    @endfor
                                </div>
                                <div class="ml-2 font-bold text-gray-700">{{ $service }}</div>
                            </div>
                        </div>

                        @error('service') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                        <!-- КНОПКИ -->

                        <button type="button" wire:click.prevent="cancelAppointment" class="white_rose_btn register_prev" style="width:100%">{{__('Відправити')}}</button>

                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
