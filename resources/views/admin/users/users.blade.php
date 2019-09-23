@extends('admin.partials.master')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::to('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ $title }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr role="row" class="heading">
                                <th>Потребител</th>
                                <th>Име</th>
                                <th>Фамилия</th>
                                <th>Пол</th>
                                <th>Имейл</th>
                                <th>Създаден</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Потребител</th>
                                <th>Име</th>
                                <th>Фамилия</th>
                                <th>Пол</th>
                                <th>Имейл</th>
                                <th>Създаден</th>
                                <th>Действие</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
            </div>
        </div>
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ URL::to('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        let table;
        $(function () {
            table = $('#users').DataTable({
                'paging': true,
                'lengthChange': true,
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "Всички"]],
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'processing': true,
                'serverSide': true,
                "order": [5, "desc"],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [6]
                }],
                ajax: '{{ route('users.ajax') }}',
                columns: [
                    {data: 'name'},
                    {data: 'first_name'},
                    {data: 'last_name'},
                    {data: 'sex'},
                    {data: 'email'},
                    {data: 'created_at'},
                    {data: 'actions'},
                ],
                "fnDrawCallback": function (oSettings) {
                    $('.a-action').click(function (e) {
                        e.preventDefault();
                        let link = $(this).attr('href');
                        $.ajax({
                            url: link,
                            method: 'get',
                            success: function (data) {
                                $('#myModal').html(data).on('hidden.bs.modal', function () {
                                    table.ajax.reload(null, false);
                                })
                            }
                        })
                    })
                }
            });
        });
    </script>
@endpush
