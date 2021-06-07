@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{ $card->user->name }}
            <small class="text-muted"><em>Ingreso de nuevo resultado de prueba COVID-19</em></small></h1>
            <form method="POST" class="form" action="{{ route('newtestresultsubmit') }}">
                @csrf

                <div class="form-group">
                    <label for="test_type">Tipo de Prueba</label>
                    <select class="form-control" id="test_type" name="test_type">
                        <option value="1" selected>Prueba rápida</option>
                        <option value="2">Prueba PCR</option>
                        <option value="3">Prueba Cuantitativa</option>
                        <option value="4">Antígenos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="result" class="@error('result') text-danger @enderror">Resultado</label>
                    <select class="form-control @error('test_date') is-invalid @enderror" id="result" name="result">
                        <option value="1" selected>Negativo para COVID-19</option>
                        <option value="2">Positivo para COVID 19</option>
                    </select>
                    @error('result')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="test_date" class="@error('test_date') text-danger @enderror">Fecha de la prueba</label>
                    <input type="date" class="form-control @error('test_date') is-invalid @enderror" id="test_date" name="test_date" required>
                    @error('test_date')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <input type="hidden" id="user_id" name="user_id" value="{{ $card->user_id }}">
                <input type="hidden" id="returnTo" name="returnTo" value="{{ $returnTo }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
