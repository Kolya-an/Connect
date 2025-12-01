@extends('layouts.base')
@section('page.title', $pageTitle ?? 'Новини')
@section('page.description', $pageDescription ?? '')
@section('content')
    {{ $slot }}
@endsection
