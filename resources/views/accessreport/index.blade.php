@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary text-center">Reporte de Control de Acceso</h1>
            <div class="text-center mt-5">
                <p>Seleccione la fecha para el reporte</p>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <form method="POST" action="{{ route('accessReport_query') }}">
                            @csrf
                            <div class="form-group">
                                <input type="date" class="form-control" name="date" id=date required>
                            </div>
                            <button class="btn btn-primary" type="submit">Ver reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
