@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <ul>
            @foreach ($accounts as $a)
                <li>{{ $a->email }}</li>
            @endforeach
            </ul>
        </div>
    </div>
@endsection
