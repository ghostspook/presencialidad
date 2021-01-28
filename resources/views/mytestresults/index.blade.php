@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-3">
            <dl>
                <dt>Status actual:</dt>
                <dd>{{ $user->userCard->getStateText() }}</dd>
                @if($user->userCard->most_recent_negative_test_result_at)
                <dt>Última prueba con resultado negativo:</dt>
                <dd>{{ $user->userCard->most_recent_negative_test_result_at->format('d-M-Y') }}</dd>
                @endif
                @if($displayNextTestResultDeadline)
                <dt>Próxima prueba:</dt>
                <dd>{{ $nextTestResultDeadline->format('d-M-Y') }}</dd>
                @endif
            </dl>
        </div>
        <div class="col-md-9">
            <h1 class="title text-primary">Mis resultados</h1>
            <table class="table mt-5">
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
                        <td>{{ $tr->test_date->format('d-M-Y') }}</td>
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
