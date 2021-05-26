@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title text-primary">Resultado de prueba</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Nombre</dt>
                        <dd>{{ $tr->user->name }}</dd>
                        <dt>Fecha</dt>
                        <dd>{{ $tr->test_date->format('d-M-Y') }}</dd>
                        <dt>Resultado</dt>
                        <dd>
                            <span class="{{ ($tr->result == 1) ? 'text-success' : 'text-danger' }}">
                                {{ $tr->getResultText() }}
                            </span>
                        </dd>
                        <dt>Ingresado por</dt>
                        <dd>
                            @if ($tr->added_by)
                            {{ $tr->added_by }}
                            @else
                            <em>desconocido</em>
                            @endif
                            ({{ $tr->created_at->format('d-M-Y') }})
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <h4>Comentarios</h4>
                    <ul>
                        @foreach($tr->comments as $c)
                        <li>
                            {{$c->created_at->format('Y-m-d')}} -
                            {{ $c->comment_text }} <span class="small">({{ $c->added_by }})</span>
                        </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('testresults_postcomment') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="comment_text"></label>
                            <textarea name="comment_text" class="form-control" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="test_result_id" value="{{ $tr->id }}">
                        <button type="submit" class="btn btn-primary btn-sm ">Añadir comentario</button>
                    </form>

                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    @if(!$tr->file)
                    <form method="POST" action="{{ route('testresults_uploadfile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="test_file" class="form-label"></label>
                            <input class="form-control" type="file" id="test_file" name="test_file" required>
                        </div>
                        <input type="hidden" name="id" value="{{ $tr->id }}">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                    @else
                    <a target="_blank" href="{{ route('testresults_download', [ 'id' => $tr->id ]) }}">Descargar archivo</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
