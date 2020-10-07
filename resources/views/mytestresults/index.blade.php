@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Mis resultados</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Resultado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test_results as $tr)
                    <tr>
                        <td>{{ $tr->test_date->format('d-M-yy') }}</td>
                        <td>
                            <span class="{{ ($tr->result == 1) ? 'text-success' : 'text-danger' }}">
                                {{ $tr->getResultText() }}
                            </span>
                        </td>
                        <td>
                            @if ($tr->file)
                            <a target="_blank" href="{{ route('myTestResults_download', [ 'id' => $tr->id ]) }}">Descargar archivo</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
