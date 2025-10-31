@extends('layouts.base')
@section('page.title','Особистий кабінет пацієнта')
@section('content')
    <main class="client-register">
        <div class="container">
            <div class="spec_register_wrapper">
                <div class="_flex-display _justify-content-between spec_register1">
                    @livewire('patient.avatar-upload')
                    @livewire('patient.patient-profile')
                </div>
            </div>
        </div>
    </main>

@endsection
