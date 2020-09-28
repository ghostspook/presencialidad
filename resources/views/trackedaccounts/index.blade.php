@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <ul>
            @foreach ($accounts as $a)
                <li>{{ $a->email }}&nbsp;
                    @if($a->user_id)
                        (<a href="{{ route('trackedaccounts_show', ['id' => $a->user_id]) }}">{{ $a->user->userCard->getStateText() }}</a>)
                    @endif
                </li>
            @endforeach
            </ul>
            <form method="POST" class="form" action="{{ route('trackedaccount_store') }}">
                @csrf
                <div class="form-control-group">
                    <label for="email">Agregar nuevo email</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </div>
            </form>
        </div>
    </div>
@endsection
