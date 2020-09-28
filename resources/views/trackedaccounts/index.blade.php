@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1 class="title">Cuentas habilitadas</h1>
            <div class="row">
                <div class="col-md-9">
                    <table class="table">
                        <tr>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                        </tr>
                        @foreach ($accounts as $a)
                            <tr>
                                <td>{{ $a->email }}</td>
                                <td>{{ $a->accountType->name }}</td>
                                @if($a->user)
                                <td>
                                    <a href="{{ route('trackedaccounts_show', ['id' => $a->user_id]) }}">
                                        {{ $a->user->name }}
                                    </a>
                                </td>
                                <td>{{ $a->user->userCard->getStateText() }}</td>
                                @else
                                <td>-</td>
                                <td>-</td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-3">
                    <h2 class="title text-primary">Añadir cuenta</h2>
                    <form method="POST" class="form" action="{{ route('trackedaccount_store') }}">
                        @csrf
                        <div class="form-control-group">
                            <label for="email">Agregar nuevo email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div class="form-group">
                                <label for="account_type_id">Tipo de cuenta:</label>
                                <select class="form-control" id="account_type_id" name="account_type_id">
                                    @foreach ($accountTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Añadir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
