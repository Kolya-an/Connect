<ul class="ul_submenu">
    @if($services->count() > 0)
        @foreach($services as $service)
            <li><a href="#">{{ $service->name }}</a></li>
        @endforeach
    @endif
</ul>
