<div class="spec_actions">
    @if (count($promotions) == 0)
        <p>{{__('Немає активних акцій.')}}</p>
    @else
        @foreach($promotions as $promo)
            <div class="_flex-display _justify-content-between _align-center spec_action">
                <div class="spec_action_content">
                    <div class="_flex-display _align-center spec_review_left">
                        <div class="_flex-display client_action_date _maxwidth768"><div class="btn white_rose_btn spec_action_date">Діє до 30.8.2025</div></div>
                        <div class="spec_review_image"><img src="{{ asset('uploads/' . $promo->doctor->photo) }}" alt=""></div>
                        <div class="spec_review_name_stars">
                            @if ($promo->doctor->reviews_count > 0)
                            <div class="_flex-display _align-center top_docs-rating _maxwidth768">
                                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none" customFrame="#000000">
                                    <path id="Star 1" d="M9.72876 5.32057C9.76892 5.44418 9.88411 5.52786 10.0141 5.52786L14.6851 5.52786C14.9758 5.52786 15.0966 5.89975 14.8615 6.07057L11.0825 8.81616C10.9774 8.89255 10.9334 9.02796 10.9735 9.15157L12.417 13.594C12.5068 13.8704 12.1904 14.1003 11.9553 13.9294L8.17634 11.1838C8.07119 11.1075 7.92881 11.1075 7.82366 11.1838L4.04469 13.9294C3.80957 14.1003 3.49323 13.8704 3.58303 13.594L5.02648 9.15157C5.06664 9.02796 5.02264 8.89255 4.91749 8.81616L1.13852 6.07057C0.903403 5.89975 1.02424 5.52786 1.31485 5.52786L5.98593 5.52786C6.11589 5.52786 6.23108 5.44418 6.27124 5.32057L7.71468 0.878116C7.80449 0.601722 8.19551 0.601722 8.28532 0.878116L9.72876 5.32057Z" fill="rgb(255,255,255)" fill-rule="evenodd" />
                                </svg>
                                <p><b>{{$promo->doctor->rating}}</b> ({{ $promo->doctor->reviews_count }})</p>
                            </div>
                            @endif
                            <p>{{$promo->doctor->second_name}} {{$promo->doctor->user->name}}</p>
                            @if($promo->doctor->types)
                                <p class="client_spec">
                                    <span>
                                        @foreach($promo->doctor->types as $type)
                                            {{$type}}{{ $loop->last ? '' : ', ' }}
                                        @endforeach
                                    </span>
                                </p>
                            @endif
                            <div class="_flex-display _justify-content-center _align-center doctor_left_address _maxwidth768">
                                <svg viewBox="0 0 12 14.2002" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12.000000" height="14.200195" fill="none" customFrame="#000000">
                                    <g id="Location">
                                        <path id="Stroke 1" d="M5.99972 4.16602C4.98679 4.16602 4.16602 4.98679 4.16602 5.99972C4.16602 7.01191 4.98679 7.83268 5.99972 7.83268C7.01191 7.83268 7.83268 7.01191 7.83268 5.99972C7.83268 4.98679 7.01191 4.16602 5.99972 4.16602Z" fill-rule="evenodd" stroke="rgb(255,255,255)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                                        <path id="Stroke 3" d="M0.5 6.04641C0.5 2.98353 2.96187 0.5 5.99964 0.5C9.03741 0.5 11.5 2.98353 11.5 6.04641C11.5 9.95881 6.87852 13.7 5.99964 13.7C5.12076 13.7 0.5 9.95881 0.5 6.04641Z" fill-rule="evenodd" stroke="rgb(255,255,255)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                                    </g>
                                </svg>
                                <span>{{$promo->doctor->city}},  {{$promo->doctor->address}}</span>
                            </div>
                            <a class="doctor_left_link _maxwidth768" href="{{route('map')}}?doctor_id={{ $promo->doctor->id}}">{{__('Дивитись на карті')}}</a>
                            @if ($promo->doctor->reviews_count > 0)
                                <div class="_flex-display _align-center top_docs-rating _minwidth769">
                                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none" customFrame="#000000">
                                        <path id="Star 1" d="M9.72876 5.32057C9.76892 5.44418 9.88411 5.52786 10.0141 5.52786L14.6851 5.52786C14.9758 5.52786 15.0966 5.89975 14.8615 6.07057L11.0825 8.81616C10.9774 8.89255 10.9334 9.02796 10.9735 9.15157L12.417 13.594C12.5068 13.8704 12.1904 14.1003 11.9553 13.9294L8.17634 11.1838C8.07119 11.1075 7.92881 11.1075 7.82366 11.1838L4.04469 13.9294C3.80957 14.1003 3.49323 13.8704 3.58303 13.594L5.02648 9.15157C5.06664 9.02796 5.02264 8.89255 4.91749 8.81616L1.13852 6.07057C0.903403 5.89975 1.02424 5.52786 1.31485 5.52786L5.98593 5.52786C6.11589 5.52786 6.23108 5.44418 6.27124 5.32057L7.71468 0.878116C7.80449 0.601722 8.19551 0.601722 8.28532 0.878116L9.72876 5.32057Z" fill="rgb(255,255,255)" fill-rule="evenodd" />
                                    </svg>
                                    <p><b>{{$promo->doctor->rating}}</b> ({{ $promo->doctor->reviews_count }})</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <h5>{{$promo->title}}</h5>
                    <p class="client_action_cost _maxwidth768"><span>{{$promo->old_price}}₴</span> {{$promo->new_price}}₴</p>
                    <p>{{$promo->description}}</p>
                </div>

                <div class="spec_action_price">
                    <div class="_flex-display _justify-content-center _align-center doctor_left_address _minwidth769">
                        <svg viewBox="0 0 12 14.2002" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="12.000000" height="14.200195" fill="none" customFrame="#000000">
                            <g id="Location">
                                <path id="Stroke 1" d="M5.99972 4.16602C4.98679 4.16602 4.16602 4.98679 4.16602 5.99972C4.16602 7.01191 4.98679 7.83268 5.99972 7.83268C7.01191 7.83268 7.83268 7.01191 7.83268 5.99972C7.83268 4.98679 7.01191 4.16602 5.99972 4.16602Z" fill-rule="evenodd" stroke="rgb(255,255,255)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                                <path id="Stroke 3" d="M0.5 6.04641C0.5 2.98353 2.96187 0.5 5.99964 0.5C9.03741 0.5 11.5 2.98353 11.5 6.04641C11.5 9.95881 6.87852 13.7 5.99964 13.7C5.12076 13.7 0.5 9.95881 0.5 6.04641Z" fill-rule="evenodd" stroke="rgb(255,255,255)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                            </g>
                        </svg>
                        <span>{{$promo->doctor->city}},  {{$promo->doctor->address}}</span>
                    </div>
                    <a class="doctor_left_link _minwidth769" href="{{route('map')}}?doctor_id={{ $promo->doctor->id}}">{{__('Дивитись на карті')}}</a>
                    <div class="_flex-display _justify-content-end client_action_date _minwidth769"><div class="btn white_rose_btn spec_action_date">Діє до 30.8.2025</div></div>
                    <p class="_minwidth769"><span>{{$promo->old_price}}₴</span> {{$promo->new_price}}₴</p>
                </div>
            </div>
        @endforeach
    @endif
    {{--<ul class="_flex-display _justify-content-center _align-center pagination">
        <li><a class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                    <rect id="Icon / Pagination / Prev" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                    <path id="Vector" d="M0.94 0L0 0.94L3.05333 4L0 7.06L0.94 8L4.94 4L0.94 0Z" fill="rgb(0,0,0)" fill-rule="nonzero" transform="matrix(-1,8.74228e-08,-8.74228e-08,-1,11,12)" />
                </svg>
            </a></li>
        <li class="pagination_current"><a class="_flex-display _justify-content-center _align-center">1</a></li>
        <li><a class="_flex-display _justify-content-center _align-center" href="#">2</a></li>
        <li><a class="_flex-display _justify-content-center _align-center" href="#">3</a></li>
        <li><a class="_flex-display _justify-content-center _align-center" href="#"><svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.000000" height="16.000000" fill="none">
                    <rect id="Icon / Pagination / Next" width="16.000000" height="16.000000" x="0.000000" y="0.000000" fill="rgb(255,255,255)" fill-opacity="0" />
                    <path id="Vector" d="M6.94 4L6 4.94L9.05333 8L6 11.06L6.94 12L10.94 8L6.94 4Z" fill="rgb(0,0,0)" fill-rule="nonzero" />
                </svg>
            </a></li>
    </ul>--}}
</div>
