@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <h1 class="title">Pruebas pendientes</h1>
        <div class="col-md-12">
            <table class="table table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
            </table>
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
                ajax: '{!! route('pendingTests_datatables') !!}',
                columns: [
                    { data: 'action', name: 'nombre' },
                    { data: 'email', name: 'email' },
                    { data: 'group_name', name: 'group_name' },
                    { data: 'state', name: 'state' },
                ]
            });
        });
    </script>
@endpush

