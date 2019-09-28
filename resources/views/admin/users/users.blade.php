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
                    <div class="col-sm-12">
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
                            <tr class="filter">
                                <form id="form-filter">
                                    <th><input type="text" class="form-control form-filter" name="filter[name]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[first_name]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[last_name]"></th>
                                    <th><select class="form-control" name="filter[sex]">
                                            <option value="">избери</option>
                                            <option value="Мъж">Мъж</option>
                                            <option value="Жена">Жена</option>
                                        </select>
                                    </th>
                                    <th><input type="text" class="form-control form-filter" name="filter[email]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[created_at]"></th>
                                    <th>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" name="filter" id="filter" class="btn btn-primary btn-secondary" title="Търси"><i
                                                    class="fa fa-search"></i></button>
                                            <button type="submit" name="clear" id="clear" class="btn btn-danger btn-secondary"
                                                    title="Изчисти филтъра"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </th>
                                </form>
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
        </div>
        <!-- Modal -->
        <div class="modal fade center" id="myModal" role="dialog">
        </div>
    </div>
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ URL::to('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                $('#myModal').modal('hide');
            }
        });
        var table;
        $(function () {
            table = $('#users').DataTable({
                processing: true,
                paging: true,
                serverSide: true,
                searching: false,
                orderCellsTop: true,
                order: [5, "desc"],
                lengthChange: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Всички"]],
                pageLength: parseInt(localStorage.getItem('usersResultsPerPare')),
                columnDefs: [{
                    orderable: false,
                    targets: [6]
                }],
                ajax: {
                    url: '{{ route('users.ajax') }}',
                    type: 'post',
                    data: function (d) {
                        d.name       = $('input[name="filter[name]"]').val();
                        d.first_name = $('input[name="filter[first_name]"]').val();
                        d.last_name  = $('input[name="filter[last_name]"]').val();
                        d.sex        = $('select[name="filter[sex]"]').val();
                        d.email      = $('input[name="filter[email]"]').val();
                        d.created_at = $('input[name="filter[created_at]"]').val();
                    }
                },
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
                    $('.delete-user').click(function () {
                        let username = $(this).data('username');
                        let userId   = $(this).data('userId');
                        Lobibox.confirm({
                            msg: `Наистина ли искате да изтриете: <strong>${username}</strong> ?`,
                            callback: function ($this, type) {
                                if (type === 'yes') {
                                    $.ajax({
                                        url: `/admin/users/${userId}/delete`,
                                        method: 'delete',
                                        success: function (data) {
                                            Lobibox.notify('success', {
                                                msg: `Потребителят <strong>${username}</strong> беше успешно изтрит.`
                                            });
                                            table.ajax.reload()
                                        }
                                    });
                                }
                            }
                        });
                    });

                    $('.a-action').click(function (e) {
                        e.preventDefault();
                        let link = $(this).attr('href');
                        $.ajax({
                            url: link,
                            method: 'get',
                            success: function (data) {
                                $('#myModal').html(data);
                            }
                        })
                    })
                }
            });
            $('#filter').click(function () {
                table.ajax.reload(null, true);
            });
            $('.form-filter').keypress(function (e) {
                if (e.which == 13) {
                    table.ajax.reload(null, true);
                }
            });
            $('#clear').click(function () {
                $('[name^="filter"]').val('');
                table.ajax.reload(null, false);
            });


            $('select[name="users_length"]').change(function () {
                localStorage.setItem('usersResultsPerPare', $('select[name="users_length"]').val());
            });
        });
    </script>
@endpush
