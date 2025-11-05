@extends('layouts.base')
@section('page.title','Сторінка користувача')
@section('content')
    <main class="client-page">
        {{ $slot }}
    </main>
@endsection
