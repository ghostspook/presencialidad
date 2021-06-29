@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{$user->name}}</h1>
            <div class="row">
                <div class="col-md-4">
                    @if($user->userCard)
                    <dl>
                        <dt>Status actual:</dt>
                        <dd>{{ $user->userCard->getStateText() }}</dd>
                        <dt>Grupo:</dt>
                        <dd>
                            @if($user->trackedAccount->group_id)
                            <a href="{{route('groups.show', ['group' => $user->trackedAccount->group])}}">
                                {{ $user->trackedAccount->group->name }}
                            </a>
                            @else
                            -
                            @endif
                        </dd>
                        <dt>Pruebas requeridas al inicio:</dt>
                        <dd>{{ $user->userCard->required_initial_test_count }}</dd>
                        @if($user->userCard->most_recent_negative_test_result_at)
                        <dt>Última prueba con resultado negativo:</dt>
                        <dd>{{ $user->userCard->most_recent_negative_test_result_at->format('d-M-Y') }}</dd>
                        @endif
                        @if($user->userCard->next_test_result_due_date)
                        <dt>Requiere prueba mantenimiento hasta:</dt>
                        <dd>
                            {{ $user->userCard->next_test_result_due_date->format('d-M-Y') }}
                            @if($user->userCard->requires_maintenance_test)
                            <span class="text-warning small">(Advertencia)</span>
                            @endif
                            <a class="small" href="{{route('extensions.create', ['user_id' => $user->id])}}">Modificar...</a>
                        </dd>
                        @endif
                    </dl>
                    <hr class="dotted">
                    <h3 class="title text-danger">Forzar transición</h3>
                    <form class="form" method="POST" action="{{ route('trackedaccount_transition') }}">
                        @csrf
                        <div class="form-group">
                            <label for="state">Transicionar al estado:</label>
                            <select class="form-control" id="state" name="state">
                                <option value="1">Pendiente inscripción</option>
                                <option value="2">Pendiente cuestionario 1</option>
                                <option value="4">Pendiente Prueba rápida 2</option>
                                <option value="5">Pendiente cuestionario 2</option>
                                <option value="10">Cuarentena mandatoria</option>
                                <option value="11">Cuarentena preventiva</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label v-for="comment_text">Comentarios <small class="text-danger">(requerido)</small></label>
                            <textarea class="form-control" id="comment_text" name="comment_text" required></textarea>
                        </div>
                        <input type="hidden" value="{{ $user->id }}" name="user_id">
                        <button type="submit" class="btn btn-danger">Transicionar</button>
                    </form>
                    @else
                    El usuario no ha iniciado sesitón todavía.
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title">Transiciones</h3>
                            <ul>
                                @foreach ($user->transitions->sortBy('id') as $t)
                                <li>
                                    <span>
                                        {{$t->created_at}} - {{ $t->getStateText() }} ({{ $t->actor}})
                                        @if($t->answer)
                                            <small>
                                                <a href="{{ route('answer_show', [ 'id' => $t->answer->id]) }}">Ver respuesta</a>
                                            </small>
                                        @endif
                                    </span>
                                @if($t->comments)
                                <div>
                                    <em class="text-muted"><small>{{$t->comments->comment_text}}</small></em>
                                </div>
                                @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title mt-3">Resultados de Pruebas</h3>
                            <ul>
                                @foreach ($user->testResults->sortBy('test_date') as $r)
                                <li>
                                    {{$r->test_date->format('Y-m-d')}} -
                                    {{ $r->getTestTypeText() }} -
                                    Resultado:
                                    <span class="{{ ($r->result == 1 || $r->test_type == 5) ? 'text-success' : 'text-danger' }}">
                                        {{ $r->getResultText() }}
                                    </span>
                                    - <a href="{{ route('testresults_show', [ 'id' => $r->id ]) }}">Ver resultado</a>
                                </li>
                                @endforeach
                            </ul>
                            @if (Auth::user()->can_enter_test_results)
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn btn-warning" href="{{ route('newtestresult', ['userId' => $user->id, 'returnTo' => 'cuenta']) }}">Ingresar nuevo resultado</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title mt-5">Registros de Vacunación</h3>
                            <ul>
                                @foreach ($user->vaccinations->sortBy('test_date') as $v)
                                <li>
                                    <span>
                                        {{$v->vaccinated_date->format('Y-m-d')}} -
                                        {{ $v->vaccineType->name }}
                                        - <a href="{{ route('vaccination_show', [ 'id' => $v->id ]) }}">Ver registro</a>
                                    </span>
                                    <div>
                                        <em class="text-muted"><small>{{$v->comments}}</small></em>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @if (Auth::user()->can_enter_test_results)
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn btn-success" href="{{ route('vaccination_create', ['userId' => $user->id, 'returnTo' => 'cuenta']) }}">Ingresar nuevo registro</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
