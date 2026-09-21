@extends('layouts.base')

@section('content')
    @livewire('patient.photo-consent-sign', ['token' => $token])
@endsection