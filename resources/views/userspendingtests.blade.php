@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <h1 class="title">Pruebas pendientes</h1>
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado</th>
                </tr>
            @foreach ($cards as $card)
                <tr>
                    <td><a href="{{ route('newtestresult', $card->user_id) }}">{{ $card->user->name }}</a></td>
                    <td>{{ $card->user->email }}</td>
                    <td>{{ $card->getStateText() }}</td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>
@endsection
