@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            {!! QrCode::size(200)->generate($a->code); !!}
        </div>
    </div>
@endsection
