@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h1 class="title text-primary">Grupos</h1>
                <div class="my-auto">
                    @if(Auth::user()->can_manage_groups)
                    <a href="{{route('groups.create')}}" class="btn btn-success">Nuevo</a>
                    @endif
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Pruebas requeridas al inicio</th>
                                <th>Requerir prueba de mantenimiento</th>
                                <th>Creado</th>
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
                ajax: '{!! route('groups.datatable') !!}',
                columns: [
                    { data: 'action', name: 'name' },
                    { data: 'default_required_initial_test_count', name: 'default_required_initial_test_count' },
                    { data: null, name: 'automatically_require_maintenance_test', render: (data, type, row) => (data.automatically_require_maintenance_test) ? 'Sí' : 'No' },
                    { data: null, name: 'created_at' , render: (data, type, row) => data.created_at.substring(0,10)},
                ]
            });
        });
    </script>
@endpush
