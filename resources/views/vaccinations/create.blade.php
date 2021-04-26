@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">{{ $card->user->name }}
            <small class="text-muted"><em>Ingresar registro de vacunación contra COVID-19</em></small></h1>
            <form method="POST" class="form" action="{{ route('vaccination_store') }}">
                @csrf

                <div class="form-group">
                    <label for="vaccine_type_id">Tipo de Vacuna</label>
                    <select class="form-control" id="vaccine_type_id" name="vaccine_type_id">
                        @foreach($vaccineTypes as $vt)
                        <option value=" {{$vt->id }}" selected>{{ $vt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="vaccinated_date" class="@error('vaccinated_date') text-danger @enderror">Fecha de vacunación</label>
                    <input type="date" class="form-control @error('vaccinated_date') is-invalid @enderror" id="vaccinated_date" name="vaccinated_date" required>
                    @error('vaccinated_date')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="comments" class="@error('comments') text-danger @enderror">Comentarios <small>(opcional)</small></label>
                    <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments"></textarea>
                    @error('comments')
                    <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <input type="hidden" id="user_id" name="user_id" value="{{ $card->user_id }}">
                <input type="hidden" id="returnTo" name="returnTo" value="{{ $returnTo }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
