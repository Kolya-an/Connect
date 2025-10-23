<div class="_flex-display _align-center" style="gap: 10px">
    <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="_flex-display _align-center cab_btn">
        <img src="{{Vite::asset('resources/images/cabimg.png')}}"><span>Особистий кабінет</span>
    </a>
    <button
        wire:click="logout"
        class="btn rose_btn">
        {{__('Вийти')}}
    </button>
</div>
