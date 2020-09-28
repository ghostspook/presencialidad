@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <div class="text-center">
                {!! QrCode::size(200)->generate($a->code); !!}
                <h2 class="title mt-5 text-primary">{{ $a->user->name }}</h2>
                <p>
                    está autorizado para ingresar hasta
                </p>
                <h2 class="title text-primary">
                    {{ $a->expires_at->day }} / {{ $a->expires_at->shortLocaleMonth }} / {{ $a->expires_at->year }}<br>
                    {{ $a->expires_at->format('h:i') }}
                </h2>
            </div>
        </div>
    </div>
@endsection
