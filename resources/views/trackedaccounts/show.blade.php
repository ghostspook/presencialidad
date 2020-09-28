@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{$user->name}}</h1>

            @if($user->userCard)
            <dl>
                <dt>Status actual:</dt>
                <dd>{{ $user->userCard->getStateText() }}</dd>
                <dt>Última prueba con resultado negativo:</dt>
                <dd>{{ $user->userCard->most_recent_negative_test_result_at}}</dd>
            </dl>
            @else
            No ha iniciado sesitón todavía.
            @endif
            <div class="mt-5">
                <h3 class="title">Transiciones</h3>
                <ul>
                    @foreach ($user->transitions as $t)
                        <li>{{$t->created_at}} - {{ $t->getStateText() }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
