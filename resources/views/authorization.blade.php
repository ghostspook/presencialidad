@extends('layouts.app')

@section('main-content')
    @if ($a->user->userCard->requires_maintenance_test)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <h3 class="alert-heading"><strong>Prueba COVID-19 de mantenimiento</strong></h3>
                <p>
                    Por favor, acérquese a Laboratorio Veris para realizarse su siguiente prueba rápida antes del
                    <strong>
                        {{ $a->user->userCard->next_test_result_due_date->addDays(-5)->day }} /
                        {{ $a->user->userCard->next_test_result_due_date->addDays(-5)->shortLocaleMonth }} /
                        {{ $a->user->userCard->next_test_result_due_date->addDays(-5)->year }}
                    </strong>
                </p>
                <hr>
                @if($a->user->userCard->most_recent_negative_test_result_at)
                <p class="mb-0">
                    <small>
                        Su última prueba con resultado negativo fue el
                        {{ $a->user->userCard->most_recent_negative_test_result_at->day }} /
                        {{ $a->user->userCard->most_recent_negative_test_result_at->shortLocaleMonth }} /
                        {{ $a->user->userCard->most_recent_negative_test_result_at->year }}
                    </small>
                </p>
                @endif
            </div>
        </div>
    </div>
    @endif
    <div  class="row">
        <div class="col-md-12">
            <div class="text-center">
                {!! QrCode::size(200)->generate($a->code); !!}
                <h2 class="title mt-5 text-primary">{{ $a->user->name }}</h2>
                <p>
                    está autorizado para ingresar hasta
                </p>
                <h2 class="title text-primary">
                    {{ $a->expires_at->day }} / {{ $a->expires_at->shortLocaleMonth }} / {{ $a->expires_at->year }}<br>
                    {{ $a->expires_at->format('h:i A') }}
                </h2>
                <a class="text-success" href="{{ route('questionnarieTwo') }}">Renovar autorización</a>
            </div>
        </div>
    </div>
@endsection
