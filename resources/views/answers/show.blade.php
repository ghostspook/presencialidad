@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Respuesta</h1>
            <div class="row">
                <div class="col-md-4">
                    <dl>
                        <dt>Usuario:</dt>
                        <dd>{{ $answer->transition->user->name }}</dd>
                        <dt>Fecha:</dt>
                        <dd>{{ $answer->created_at->toDateString() }}</dd>
                        <dt>Hora:</dt>
                        <dd>{{ $answer->created_at->toTimeString() }}</dd>
                    </dl>
                </div>
                <div class="col-md-8">
                    {{ $answer->answers_text }}
                </div>
            </div>
        </div>
    </div>
@endsection
