@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Mis vacunas</h1>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Vacuna</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vaccinations as $v)
                    <tr>
                        <td>{{ $v->vaccinated_date->format('d-M-Y') }}</td>
                        <td>
                            {{ $v->vaccineType->name }}
                        </td>
                        <td>
                            @if ($v->file)
                            <a target="_blank" href="{{ route('myvaccinations.download', [ 'id' => $v->id ]) }}">Descargar archivo</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
