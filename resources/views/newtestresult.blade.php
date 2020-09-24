@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <form method="POST" class="form" action="{{ route('newtestresultsubmit') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter email" readonly name="name" value="{{ $card->user->name }}">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
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
