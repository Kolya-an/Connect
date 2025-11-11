<div class="footer_proc">
    @if($services->count() > 0)
        <h6>{{__('Обрати процедуру')}}</h6>
        <ul>
            @foreach($services as $service)
                <li><a href="#">{{ $service->name }}</a></li>
            @endforeach
        </ul>
    @endif
</div>
