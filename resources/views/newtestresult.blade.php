@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{ $card->user->name }}
            <small class="text-muted"><em>Ingreso de nuevo resultado de prueva COVID-19</em></small></h1>
            <form method="POST" class="form" action="{{ route('newtestresultsubmit') }}">
                @csrf

                <div class="form-group">
                    <label for="test_type">Tipo de Prueba</label>
                    <select class="form-control" id="test_type" name="test_type">
                        <option value="1" selected>Prueba rápida</option>
                        <option value="2">Prueba PCR</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="result">Resultado</label>
                    <select class="form-control" id="result" name="result">
                        <option value="1" selected>Negativo para COVID-19</option>
                        <option value="2">Positivo para COVID 19</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="test_date">Fecha de la prueba</label>
                    <input type="date" class="form-control" id="test_date" name="test_date">
                </div>
                <input type="hidden" id="user_id" name="user_id" value="{{ $card->user_id }}">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
@endsection
