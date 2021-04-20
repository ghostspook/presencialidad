@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <h1 class="title">Cuentas habilitadas</h1>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Grupo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="title text-primary mt-5">Añadir cuenta</h2>
                    <form method="POST" class="form" action="{{ route('trackedaccount_store') }}">
                        @csrf
                        <div class="form-control-group">
                            <label for="email">Agregar nuevo email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div class="form-group">
                                <label for="account_type_id">Tipo de cuenta:</label>
                                <select class="form-control" id="account_type_id" name="account_type_id">
                                    @foreach ($accountTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="group_id">Grupo:</label>
                                <select class="form-control" id="group_id" name="group_id">
                                    <option value="-">Ninguno</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Añadir</button>
                    </form>
                </div>
                <div class="col-md-8">

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
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
                },
                ajax: '{!! route('trackedaccounts_datatables') !!}',
                columns: [
                    { data: 'action', name: 'email' },
                    { data: 'account_type_name', name: 'account_type_name' },
                    { data: null, name: 'user_name', render: (data, type, row) => (data.user_name) ? data.user_name : '-' },
                    { data: null, name: 'group_name', render: (data, type, row) => (data.group_name) ? data.group_name : '-' },
                    { data: 'state_text', name: 'state_text', sortable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
