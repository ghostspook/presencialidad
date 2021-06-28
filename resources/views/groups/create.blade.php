@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Nuevo Grupo</h1>
            <form method="POST" class="form" action="{{ route('grupos.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="@error('name') text-danger @enderror">
                        Fecha de la prueba
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" required value="{{old('name')}}">
                    @error('name')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="default_required_initial_test_count"
                            class="@error('default_required_initial_test_count') text-danger @enderror">
                        Pruebas rápidas requeridas al inicio
                    </label>
                    <select class="form-control @error('default_required_initial_test_count') is-invalid @enderror"
                            id="default_required_initial_test_count"
                            name="default_required_initial_test_count">
                        <option value="1">1</option>
                        <option value="2" selected>2</option>
                    </select>
                    @error('default_required_initial_test_count')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="automatically_require_maintenance_test"
                            class="@error('automatically_require_maintenance_test') text-danger @enderror">
                        Requiere pruebas de mantenimiento de manera regular
                    </label>
                    <select class="form-control @error('automatically_require_maintenance_test') is-invalid @enderror"
                            id="automatically_require_maintenance_test"
                            name="automatically_require_maintenance_test">
                        <option value="1" selected>Sí</option>
                        <option value="0">No</option>
                    </select>
                    @error('automatically_require_maintenance_test')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
