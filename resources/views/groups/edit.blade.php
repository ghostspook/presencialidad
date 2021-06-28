@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Editar: {{$group->name}}</h1>
            <form method="POST" class="form" action="{{ route('groups.update', ['group' => $group]) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="@error('name') text-danger @enderror">
                        Nombre
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" required value="{{$group->name}}">
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
                        <option value="1" @if($group->default_required_initial_test_count == 1) selected @endif>1</option>
                        <option value="2" @if($group->default_required_initial_test_count == 2) selected @endif>2</option>
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
                        <option value="1" @if($group->automatically_require_maintenance_test == 1) selected @endif>Sí</option>
                        <option value="0" @if($group->automatically_require_maintenance_test == 0) selected @endif>No</option>
                    </select>
                    @error('automatically_require_maintenance_test')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
@endsection
