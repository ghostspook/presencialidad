@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        @if (session('status'))
            <div class="alert alert-warning">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-12">
            Aquí va el texto
        </div>
    </div>
@endsection
