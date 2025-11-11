@extends('layouts.base')
@section('page.title', $pageTitle ?? 'Стаття')
@section('content')
    {{ $slot }}
@endsection
