<ul class="ul_submenu">
    @if($services->count() > 0)
        @foreach($services as $service)
            <li><a href="{{ route('map', ['service_id' => $service->id]) }}">{{ $service->name }}</a></li>
        @endforeach
    @endif
</ul>
