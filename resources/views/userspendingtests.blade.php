@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <ul>
            @foreach ($cards as $card)
                <li><a href="{{ route('newtestresult', $card->user_id) }}">{{ $card->user->name }}</a> ({{ $card->getStateText() }})</li>
            @endforeach
            </ul>
        </div>
    </div>
@endsection
