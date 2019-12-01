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
                    <!-- form start -->
                    <form class="form-horizontal" id="form-create-category" autocomplete="off" method="post" action="{{ route('categories.store') }}">
                        <div class="form-group">
                            <label for="title" class="col-sm-1 control-label">Име</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Име">
                                <span class="error" id="title-error"></span>
                            </div>

                            <label for="alias" class="col-sm-1 control-label">Псевдоним</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="alias" id="alias" placeholder="Псевдоним">
                                <span class="error" id="alias-error"></span>
                            </div>

                            <label for="name" class="col-sm-1 control-label">Категория</label>
                            <div class="col-sm-2">
                                <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%;">
                                </select>
                            </div>

                            <button type="submit" class="btn btn-default" id="save">Запиши</button>
                        </div>
                    </form>

                    <div class="col-xs-12">
                        <table id="categories" class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr role="row" class="heading">
                                <th>Име</th>
                                <th>Псевдоним</th>
                                <th>Родителска категория</th>
                                <th>Действие</th>
                            </tr>
                            <tr class="filter">
                                <form id="form-filter">
                                    <th><input type="text" class="form-control form-filter" name="filter[title]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[alias]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[parent]"></th>
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
                                <th>Име</th>
                                <th>Псевдоним</th>
                                <th>Родителска категория</th>
                                <th>Действие</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    </div>
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ URL::to('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        let table;
        $(function () {
            $('#save').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("categories.store") }}',
                    data: $('#form-create-category').serialize(),
                    method: 'post',
                    success: function (data) {
                        table.ajax.reload(null, false);
                        Lobibox.notify('success', {
                            showClass: 'rollIn',
                            hideClass: 'rollOut',
                            msg: `Категорията <strong>${$('[name="title"]').val()}</strong> беше създадена успешно`
                        });
                        $('.error').html('');
                        $('[name="title"]').val('');
                        $('[name="alias"]').val('');
                    },
                    error: function (data) {
                        $('.error').html('');
                        for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
                            if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
                                let key = Object.keys(data.responseJSON.errors)[i];
                                $('#' + key + '-error').html(data.responseJSON.errors[key]);
                            }
                        }
                        Lobibox.notify('error', {
                            showClass: 'rollIn',
                            hideClass: 'rollOut',
                            msg: 'Възникна някаква грешка при опита за запис на данните'
                        });
                    }
                });
            })
            table = $('#categories').DataTable({
                paging: false,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                order: [0, "asc"],
                columnDefs: [{
                    orderable: false,
                    targets: [3],
                }],
                ajax: {
                    "url": '{{ route('categories.ajax') }}',
                    "type": "POST",
                    data: function (d) {
                        d.title  = $('input[name="filter[title]"]').val();
                        d.alias  = $('input[name="filter[alias]"]').val();
                        d.parent = $('input[name="filter[parent]"]').val();
                    }
                },
                columns: [
                    {data: 'title'},
                    {data: 'alias'},
                    {data: 'parent_id'},
                    {data: 'actions'},
                ],
                "fnDrawCallback": function (oSettings) {
                    $('#parent_id').html('');
                    let categoriesData = table.rows().data().sort();
                    let o              = new Option("Без", '');
                    $(o).html('Без');
                    $('#parent_id').append(o);
                    for (let i = 0; i < categoriesData.length; i++) {
                        let o = new Option(`${categoriesData[i]['title']} (${categoriesData[i]['alias']})`, categoriesData[i]['id']);
                        $(o).html(`${categoriesData[i]['title']} (${categoriesData[i]['alias']})`);
                        $('#parent_id').append(o);
                    }

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
        });
        $('#title').on('input', function () {
            $('#alias').val($(this).val());
        })
        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                $('#myModal').modal('hide');
            }
        });
        $(document).on('click', '.delete-category', function (e) {
            let target = $(e.target);
            if (target.is("i")) {
                target = target.parent();
            }

            Lobibox.confirm({
                msg: `Наистина ли искате да изтриете категорията: <strong>${target.data('title')}</strong>?`,
                callback: function ($this, type) {
                    if (type === 'yes') {
                        $.ajax({
                            url: `${target.data('route')}`,
                            method: 'delete',
                            success: function (data) {
                                Lobibox.notify('success', {
                                    msg: `Категорията <strong>${target.data('title')}</strong> беше успешно изтрита`
                                });
                                table.ajax.reload()
                            }
                        });
                    }
                }
            });

        });
    </script>
@endpush
