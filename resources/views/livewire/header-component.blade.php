<div class="_flex-display _align-center" style="gap: 10px">
    @if($isDoctor)
        <a href="{{ route('doctor.dashboard') }}" class="_flex-display _align-center cab_btn">
            <img src="{{ asset('uploads/' . $userPhotoUrl) }}"><span>{{__('Особистий кабінет')}}</span>
        </a>
    @else
        <a href="{{ route('user.profile', ['id' => Auth::id()]) }}" class="_flex-display _align-center cab_btn">
            <img src="{{ asset('uploads/' . $userPhotoUrl) }}"><span>{{__('Особистий кабінет')}}</span>
        </a>
    @endif
    <button
        wire:click="logout"
        class="btn rose_btn">
        {{__('Вийти')}}
    </button>
</div>
