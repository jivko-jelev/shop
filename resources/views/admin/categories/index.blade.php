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
                        @csrf
                        <div class="form-group">
                            <label for="title" class="col-sm-1 control-label">Име</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Име" value="{{ old('title') }}">
                                <span class="error" id="name-error"></span>
                            </div>

                            <label for="name" class="col-sm-1 control-label">Категория</label>
                            <div class="col-sm-2">
                                <select class="form-control select2" id="select-categories" style="width: 100%;">
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
                    }
                });
            })
            table = $('#categories').DataTable({
                'paging': false,
                'lengthChange': false,
                'lengthMenu': [[-1], ["Всички"]],
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
                    $('#select-categories').html('');
                    let categoriesData                = table.rows().data().sort();
                    let o                             = new Option("Без", '');
                    $(o).html('Без');
                    $('#select-categories').append(o);
                    for (let i = 0; i < categoriesData.length; i++) {
                        let o = new Option(categoriesData[i]['title'], categoriesData[i]['id']);
                        $(o).html(categoriesData[i]['title']);
                        $('#select-categories').append(o);
                    }

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
