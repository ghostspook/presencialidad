@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title text-primary">{{$group->name}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between">
                            Información General
                            <div class="my-auto">
                                @if(Auth::user()->can_manage_groups)
                                <a href="{{route('groups.edit', ['group'=>$group])}}" class="btn btn-primary btn-sm pull-right">Editar</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <dl>
                                <dt>Nombre</dt>
                                <dd>{{ $group->name }}</dd>
                                <dt>Pruebas rápidas requeridas al inicio</dt>
                                <dd>{{ $group->default_required_initial_test_count }}</dd>
                                <dt>Requiere pruebas de mantenimiento de manera regular</dt>
                                <dd>
                                    {{($group->automatically_require_maintenance_test) ? 'Sí' : 'No'}}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h2 class="title mt-5">Cuentas habilitadas</h1>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Próxima prueba</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
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
                serverSide: true,
                pageLength: 100,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
                },
                ajax: '{!! route('groups.users.datatable', ['id' => $group->id]) !!}',
                columns: [
                    { data: 'action', name: 'email' },
                    { data: 'account_type_name', name: 'account_type_name' },
                    { data: null, name: 'user_name', render: (data, type, row) => (data.user_name) ? data.user_name : '-' },
                    { data: 'state_text', name: 'state_text', sortable: false, searchable: false },
                    { data: 'next_test_due_for', name: 'next_test_due_for', sortable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
