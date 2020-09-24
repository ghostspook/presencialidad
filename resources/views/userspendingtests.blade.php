@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            @foreach ($cards as $card)
                <p>{{ $card->user->name }} ({{ $card->getStateText() }})</p>
            @endforeach
        </div>
    </div>
@endsection
