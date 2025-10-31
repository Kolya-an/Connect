@extends('layouts.base')
@section('page.title','Особистий кабінет доктора')
@section('content')
    <main class="spec-register">
            @livewire('doctor.dashboard')
    </main>
@endsection
