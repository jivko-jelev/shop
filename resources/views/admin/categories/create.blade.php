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
                    <form class="form-horizontal" id="form-category" autocomplete="off" method="post"
                          action="{{ route('categories.store') }}">
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Име</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Име">
                                        <span class="error" id="title-error"></span>
                                    </div>

                                    <label for="alias" class="col-sm-2 control-label">Псевдоним</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="alias" id="alias" placeholder="Псевдоним">
                                        <span class="error" id="alias-error"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="parent_id" class="col-sm-2 control-label">Главна Категория</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2" id="parent_id" name="parent_id">
                                            <option value="">Без</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }} ({{ $category->alias }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="property_name[]" class="col-sm-2 control-label">Атрибут</label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="property_name[]" id="property_name[]"
                                               placeholder="Атрибут">
                                        <span class="error" id="alias-error-modal"></span><br>
                                        <button class="btn btn-danger btn-block delete-property" type="button">Изтрий</button>
                                        <button class="btn btn-primary btn-block add-property" type="button">Добави още един атрибут
                                        </button>
                                    </div>

                                    <div class="col-md-6">
                                        <textarea name="sub_property[]" class="form-control" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- /.box-body -->
                            <button type="submit" id="submit" class="btn btn-primary pull-right">Запиши</button>
                            <!-- /.box-footer -->
                        </div>
                        @csrf
                    </form>
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
            $('#form-category').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("categories.store") }}',
                    data: $('#form-category').serialize(),
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
                        $('#parent_id').html('');
                        $('#parent_id').append(`<option value="">Без</option>`)
                        for (let i = 0; i < data.length; i++) {
                            $('#parent_id').append(`<option value="${data[i]['id']}">${data[i]['title']} (${data[i]['alias']})</option>`)
                        }
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
                        d.title = $('input[name="filter[title]"]').val();
                        d.alias = $('input[name="filter[alias]"]').val();
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

        function createNewAttribute() {
            $('.modal-body .box-body').append('                                <div class="form-group">\n' +
                '                                    <label for="property_name[]" class="col-sm-2 control-label">Атрибут</label>\n' +
                '\n' +
                '                                    <div class="col-sm-4">\n' +
                '                                        <input type="text" class="form-control" name="property_name[]" id="property_name[]" placeholder="Атрибут">\n' +
                '                                        <span class="error" id="alias-error-modal"></span><br>\n' +
                '                                        <button class="btn btn-danger btn-block delete-property" type="button">Изтрий</button>\n' +
                '                                        <button class="btn btn-primary btn-block add-property" type="button">Добави още един атрибут</button>\n' +
                '                                    </div>\n' +
                '                                    \n' +
                '                                    <div class="col-md-6">\n' +
                '                                        <textarea name="sub_property[]" class="form-control" rows="6"></textarea>\n' +
                '                                    </div>\n' +
                '                                </div>\n')

            $('.delete-property').off();
            $('.delete-property').click(function () {
                $(this).closest('.form-group').remove();
            });

            $('.add-property').off();
            $('.add-property').click(function () {
                createNewAttribute();
            });
        }

        $('.delete-property').click(function () {
            $(this).closest('.form-group').remove();
        });

        $('.add-property').click(function () {
            createNewAttribute();
        });
    </script>
@endpush
