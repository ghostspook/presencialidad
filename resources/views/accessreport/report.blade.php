@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title text-primary">Reporte de Control de Acceso</h1>
            <h2> {{ $date }}</h2>
            <div class="row mt-3">
                <div class="col-md-3">
                    <form method="POST" class="form-inline" action="{{ route('accessReport_query') }}">
                        @csrf
                        <label class="sr-only" for="date">Seleccione otra fecha</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ $date }}" required>
                        <button class="btn btn-primary ml-3" type="submit">Consultar</button>
                    </form>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Grupo</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
                },
                ajax: '{!! route('accessReport_datatables', $date) !!}',
                columns: [
                    { data: 'time', name: 'time' },
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'groupname', name: 'groupname' },
                    { data: 'authorized', name: 'authorized' }
                ],
                "createdRow": function( row, data, dataIndex) {
                    if( data.authorized ==  'No autorizado'){
                        $(row).addClass('text-danger');
                    }
                }
            });
        });
    </script>
@endpush
