@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary text-center">Ingrese el resultado de su prueba PCR para COVID-19</h1>
            <div class="text-center mt-5">
                <img src="/images/lab-test.png">
            </div>
            <h3 class="title text-center mt-5">Para poder asistir presencialmente deberá confirmar el resultado negativo de una prueba PCR</h2>
            <form method="POST" class="form mt-5" action="{{ route('pcrtest_store') }}">
                @csrf

                <div class="form-group">
                    <label for="result">Me he realizado una prueba y el resultado fue:</label>
                    <select class="form-control" id="result" name="result">
                        <option value="1" selected>Negativo para COVID-19</option>
                        <option value="2">Positivo para COVID 19</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="test_date" class="@error('test_date') text-danger @enderror">Fecha de la prueba</label>
                    <input type="date" class="form-control @error('test_date') is-invalid @enderror" id="test_date" name="test_date" required>
                    @error('test_date')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
@endsection
