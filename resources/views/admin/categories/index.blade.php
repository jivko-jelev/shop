@extends('admin.partials.master')

@section('styles')
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
                            msg: 'Възникна някаква грешка при опита за промяна на данните на потребителя'
                        });
                    }
                });
            })
            table = $('#categories').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'processing': true,
                'serverSide': true,
                "order": [0, "asc"],
                "ajax": {
                    "url": '{{ route('categories.ajax') }}',
                    "type": "POST"
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
                        let o = new Option(`${categoriesData[i]['title']} (${categoriesData[i]['alias']})` , categoriesData[i]['id']);
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
        });
        $('#title').on('input', function () {
            $('#alias').val($(this).val());
        })
    </script>
@endpush
