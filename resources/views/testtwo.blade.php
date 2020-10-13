@extends('layouts.app')

@section('main-content')
<div  class="row">
    <div class="col-md-12">
        <div class="text-center">
            <img src="/images/lab-test.png">
        </div>
        <h2 class="display text-center mt-5">Por favor, acérquese a Veris a realizarse la</h2>
        <h1 class="display text-center"><strong class="text-success">Siguiente</strong><span class="text-primary"> Prueba Rápida.</span></h1>
    <p class="text-center mt-5 text-muted">
        <small>
            Su última prueba con resultado negativo fue el<br>
            <strong>
                {{ Auth::user()->userCard->most_recent_negative_test_result_at->format('d-M-yy') }}
            </strong>
        </small>

    </p>
    </div>
</div>
@endsection
