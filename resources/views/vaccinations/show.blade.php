@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Registro de Vacunación</h1>
            <dl>
                <dt>Nombre</dt>
                <dd>{{ $v->user->name }}</dd>
                <dt>Fecha</dt>
                <dd>{{ $v->vaccinated_date->format('d-M-Y') }}</dd>
                <dt>Vacuna</dt>
                <dd>
                    {{ $v->vaccineType->name }}
                </dd>
                @if($v->comments)
                <dt>Comentarios</dt>
                <dd>{{ $v->comments }}</dd>
                @endif
                <dt>Ingresado por</dt>
                <dd>
                    @if ($v->added_by)
                    {{ $v->added_by }}
                    @else
                    <em>desconocido</em>
                    @endif
                    ({{ $v->created_at->format('d-M-Y') }})
                </dd>
            </dl>
            <div class="row">
                <div class="col-md-4">
                    @if(!$v->file)
                    <form method="POST" action="{{ route('vaccination_uploadfile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="test_file" class="form-label"></label>
                            <input class="form-control" type="file" id="test_file" name="test_file" required>
                        </div>
                        <input type="hidden" name="id" value="{{ $v->id }}">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                    @else
                    <a target="_blank" href="{{ route('vaccination_download', [ 'id' => $v->id ]) }}">Descargar archivo</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
