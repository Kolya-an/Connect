@extends('layouts.base')

@section('page.title', $page->meta_name ?? $page->title)
@section('page.description', $page->meta_desc)

@section('content')
    <div class="container page-content">
        <center><h1>{{ $page->title }}</h1></center>

        <div class="page-content">
            {!! $page->content !!}
        </div>
    </div>
@endsection
