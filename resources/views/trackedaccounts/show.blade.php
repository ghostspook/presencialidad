@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{$user->name}}</h1>
            <div class="row">
                <div class="col-md-4">
                    @if($user->userCard)
                    <dl>
                        <dt>Status actual:</dt>
                        <dd>{{ $user->userCard->getStateText() }}</dd>
                        @if($user->userCard->most_recent_negative_test_result_at)
                        <dt>Última prueba con resultado negativo:</dt>
                        <dd>{{ $user->userCard->most_recent_negative_test_result_at->toDateString() }}</dd>
                        @endif
                    </dl>
                    <hr class="dotted">
                    <h3 class="title text-danger">Forzar transición</h3>
                    <form class="form" method="POST" action="{{ route('trackedaccount_transition') }}">
                        @csrf
                        <div class="form-group">
                            <label for="state">Transicionar al estado:</label>
                            <select class="form-control" id="state" name="state">
                                <option value="2">Pendiente cuestionario 1</option>
                                <option value="4">Pendiente Prueba rápida 2</option>
                                <option value="5">Pendiente cuestionario 2</option>
                                <option value="10">Cuarentena mandatoria</option>
                                <option value="11">Cuarentena preventiva</option>
                            </select>
                        </div>
                        <input type="hidden" value="{{ $user->id }}" name="user_id">
                        <button type="submit" class="btn btn-danger">Transicionar</button>
                    </form>
                    @else
                    El usuario no ha iniciado sesitón todavía.
                    @endif
                </div>
                <div class="col-md-8">
                    <h3 class="title">Transiciones</h3>
                    <ul>
                        @foreach ($user->transitions as $t)
                        <li>{{$t->created_at}} - {{ $t->getStateText() }} ({{ $t->actor}})
                        @if($t->answer)
                            <small>
                                <a href="{{ route('answer_show', [ 'id' => $t->answer->id]) }}">Ver respuesta</a>
                            </small>
                        @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
