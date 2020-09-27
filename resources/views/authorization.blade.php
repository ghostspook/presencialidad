@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <div class="text-center">
                {!! QrCode::size(200)->generate($a->code); !!}
                <h1 class="title mt-5">Código QR de Autorización</h1>
                <p>
                    Válido hasta el
                </p>
                <h2>
                    {{ $a->expires_at->day }} / {{ $a->expires_at->month }} / {{ $a->expires_at->year }}<br>
                    {{ $a->expires_at->hour }}:{{ $a->expires_at->minute }}
                </h2>
            </div>
        </div>
    </div>
@endsection
