@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{ $user->name }}
            <small class="text-muted"><em>Modificar fecha de siguiente prueba COVID-19</em></small></h1>
            <form method="POST" class="form" action="{{ route('extensions.store') }}">
                @csrf

                <div class="form-group">
                    <label for="new_date" class="@error('new_date') text-danger @enderror">Nueva fecha de siguiente prueba</label>
                    <input type="date"
                        class="form-control @error('new_date') is-invalid @enderror" id="new_date"
                        name="new_date"
                        value="{{old('new_date')}}"
                        required>
                    @error('new_date')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="comments" class="@error('comments') text-danger @enderror">
                        Comentarios <small>(opcional)</small>
                    </label>
                    <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments">{{old('comments')}}</textarea>
                    @error('comments')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
@endsection
